document.addEventListener("DOMContentLoaded", function () {
  // Отримуємо елементи DOM один раз після завантаження сторінки.
  const sportImage = document.getElementById("sportImage");
  const imageCaption = document.getElementById("imageCaption");
  const toggleGameBtn = document.getElementById("toggleGameBtn");
  const changeContentBtn = document.getElementById("changeContentBtn");
  const changeBgBtn = document.getElementById("changeBgBtn");
  const themeToggleBtn = document.getElementById("themeToggleBtn");

  const sportText = document.getElementById("sportText");
  const scoreText = document.getElementById("scoreText");
  const changeCounter = document.getElementById("changeCounter");

  const openModalBtn = document.getElementById("openModalBtn");
  const closeModalBtn = document.getElementById("closeModalBtn");
  const saveNameBtn = document.getElementById("saveNameBtn");
  const modalOverlay = document.getElementById("modalOverlay");
  const userNameInput = document.getElementById("userNameInput");
  const modalError = document.getElementById("modalError");
  const greetingResult = document.getElementById("greetingResult");

  const storageKeys = {
    userName: "lab4UserName",
    theme: "lab4Theme"
  };

  const imageVariants = [
    {
      src: "assets/2.webp",
      alt: "Футбольний м'яч",
      caption: "Поточний вид спорту: Футбол"
    },
    {
      src: "assets/1.webp",
      alt: "Баскетбольний м'яч",
      caption: "Поточний вид спорту: Баскетбол"
    }
  ];

  const backgroundPalettes = {
    light: ["#f4f7fb", "#dbeafe", "#fde68a", "#bbf7d0"],
    dark: ["#17212d", "#11283f", "#2a243a", "#13302f"]
  };

  let imageIndex = 0;
  let isGameStarted = false;
  let contentToggle = false;
  let contentChangeCount = 0;
  let backgroundIndex = 0;

  function applyImageState() {
    const currentImage = imageVariants[imageIndex];
    sportImage.src = currentImage.src;
    sportImage.alt = currentImage.alt;
    imageCaption.textContent = currentImage.caption;

    // Додаємо CSS-клас анімації після зміни джерела зображення.
    sportImage.classList.remove("swapped");
    void sportImage.offsetWidth;
    sportImage.classList.add("swapped");
  }

  function applyBackgroundColor() {
    const isDarkTheme = document.body.classList.contains("dark-theme");
    const mode = isDarkTheme ? "dark" : "light";
    const palette = backgroundPalettes[mode];
    const color = palette[backgroundIndex % palette.length];

    document.body.style.setProperty("--dynamic-bg", color);
  }

  function setTheme(themeName) {
    const isDark = themeName === "dark";
    document.body.classList.toggle("dark-theme", isDark);
    themeToggleBtn.textContent = isDark ? "Увімкнути світлу тему" : "Увімкнути темну тему";
    localStorage.setItem(storageKeys.theme, themeName);

    // Після зміни теми одразу оновлюємо фон з активної палітри.
    applyBackgroundColor();
  }

  function openModal() {
    modalOverlay.classList.remove("hidden");
    modalError.textContent = "";
    userNameInput.focus();
  }

  function closeModal() {
    modalOverlay.classList.add("hidden");
    modalError.textContent = "";
  }

  function saveUserName() {
    const name = userNameInput.value.trim();

    if (!name) {
      modalError.textContent = "Будь ласка, введіть ім'я.";
      return;
    }

    localStorage.setItem(storageKeys.userName, name);
    greetingResult.textContent = "Привіт, " + name + "! Радий бачити тебе на сторінці спорту.";
    closeModal();
  }

  function restoreUserName() {
    const savedName = localStorage.getItem(storageKeys.userName);

    if (savedName) {
      userNameInput.value = savedName;
      greetingResult.textContent = "Привіт, " + savedName + "! Радий бачити тебе на сторінці спорту.";
    }
  }

  sportImage.addEventListener("click", function () {
    imageIndex = (imageIndex + 1) % imageVariants.length;
    applyImageState();
  });

  toggleGameBtn.addEventListener("click", function () {
    isGameStarted = !isGameStarted;
    toggleGameBtn.textContent = isGameStarted ? "Завершити гру" : "Почати гру";
  });

  changeContentBtn.addEventListener("click", function () {
    contentToggle = !contentToggle;
    contentChangeCount += 1;

    if (contentToggle) {
      sportText.textContent = "Вид спорту: Баскетбол.";
      scoreText.textContent = "Рахунок: 78:74";
    } else {
      sportText.textContent = "Вид спорту: Футбол.";
      scoreText.textContent = "Рахунок: 1:0";
    }

    changeCounter.textContent = String(contentChangeCount);
  });

  changeBgBtn.addEventListener("click", function () {
    backgroundIndex += 1;
    applyBackgroundColor();
  });

  themeToggleBtn.addEventListener("click", function () {
    const nextTheme = document.body.classList.contains("dark-theme") ? "light" : "dark";
    setTheme(nextTheme);
  });

  openModalBtn.addEventListener("click", openModal);
  closeModalBtn.addEventListener("click", closeModal);
  saveNameBtn.addEventListener("click", saveUserName);

  modalOverlay.addEventListener("click", function (event) {
    if (event.target === modalOverlay) {
      closeModal();
    }
  });

  // Додаємо закриття модального вікна клавішею Esc.
  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape" && !modalOverlay.classList.contains("hidden")) {
      closeModal();
    }
  });

  // Відновлюємо збережену тему та ім'я користувача під час ініціалізації.
  const savedTheme = localStorage.getItem(storageKeys.theme) || "light";
  setTheme(savedTheme);
  restoreUserName();
  applyImageState();
});

