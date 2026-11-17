export function request(method, url, payload) {
  return new Promise((resolve, reject) => {
    const xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
    xhr.responseType = "json";
    xhr.timeout = 10000;
    if (payload !== undefined) {
      xhr.setRequestHeader("Content-Type", "application/json");
    }
    xhr.onload = () => {
      const body = xhr.response;
      if (xhr.status >= 200 && xhr.status < 300) {
        resolve(body);
        return;
      }
      const message = body?.errors
        ? Object.values(body.errors).flat().join(" ")
        : body?.detail || body?.title;
      reject(new Error(message || `Помилка HTTP ${xhr.status}`));
    };
    xhr.onerror = () => reject(new Error("Сервер недоступний."));
    xhr.ontimeout = () => reject(new Error("Час очікування минув."));
    xhr.send(payload === undefined ? null : JSON.stringify(payload));
  });
}
