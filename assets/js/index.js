function getParamsByHash(hash) {
  const [, params] = String(hash).split("?");
  const result = {};

  params.split("&").forEach((param) => {
    const [key, value] = param.split("=");
    result[key] = value;
  });

  return result;
}

window.addEventListener("hashchange", function () {
  let timerId, timerCount;
  const newHash = window.location.hash;
  const queryParams = getParamsByHash(newHash);
  const trxId = queryParams["trx_id"];
  const orderId = queryParams["order_id"];
  const redirectUrl = queryParams["woocommerce_url_redirect"];

  if (document.querySelector("#yumit-pay-modal")) {
    return;
  }

  const onClickBackgroundModal = () => {
    const modal = document.querySelector("#yumit-pay-modal");
    if (modal) {
      document.querySelector("#yumit-pay-modal").remove();
    }
  };

  const onPaymentsWebBack = (status = "failed") => {
    if (status == "stop_payment" || status == "close") {
      const [url] = location.href.split("#");
      return (this.window.location.href = url);
    }
    onClickBackgroundModal();
    fetch(yumitConfigs.url, {
      method: "POST",
      body: new URLSearchParams({
        action: "yumit_pay_webhook",
        status,
        order_id: orderId,
        trx_id: trxId,
        none: yumitConfigs.nonce,
      }),
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    })
      .then((request) => request.text())
      .then((response) => {
        console.log("Error data: ", response);
        window.location.href = decodeURIComponent(redirectUrl);
      });
  };

  const createYumitModal = () => {
    const modal = document.createElement("div");
    modal.id = "yumit-pay-modal";
    modal.classList.add("yumit-pay-modal");
    const iframeParams = new URLSearchParams({
      trxId,
      isExternal: true,
      externalUrl: location.origin,
    });

    const prevAnimationDiv = document.createElement("div");
    prevAnimationDiv.classList.add("yumit-pay-modal__child");
    prevAnimationDiv.classList.add("spinner");
    modal.appendChild(prevAnimationDiv);

    const iframe = document.createElement("iframe");
    iframe.src = `${yumitConfigs.paymentsWebUrl}?${iframeParams.toString()}`;
    iframe.style.display = "none";

    window.addEventListener("message", function ({ data }) {
      const type = data?.type;
      if (type == "copy") {
        navigator.clipboard.writeText(data.data);
      }
      if (type == "response") {
        onPaymentsWebBack(data?.status);
      }

      if (type == "close") {
        onPaymentsWebBack(type);
      }

      if (type == "userPay" && timerId != null) {
        this.clearInterval(timerId);
      }

      if (type == "timeRemaining") {
        const timeRemaining = data.data.timeRemaining;
        timerCount = timeRemaining;

        timerId = this.setInterval(() => {
          timerCount--;
          if (timerCount <= 0) {
            onPaymentsWebBack("stop_payment");
            this.clearInterval(timerId);
          }
        }, 1200);
      }
    });

    modal.appendChild(iframe);

    setTimeout(() => {
      setTimeout(() => {
        prevAnimationDiv.style.opacity = 0;
        iframe.style.backgroundColor = "transparent";
        iframe.classList.add(
          "yumit-pay-modal__child",
          "yumit-pay-modal__animation"
        );
        iframe.allow = "clipboard-read *; clipboard-write self *";

        setTimeout(() => {
          iframe.style.display = "block";
          prevAnimationDiv.remove();
        }, 100);
      }, 1000);
    }, 4000);

    document.querySelector("body").appendChild(modal);
  };

  if (trxId && redirectUrl && newHash.startsWith("#yumit-pay-modal")) {
    createYumitModal();
  }
});
