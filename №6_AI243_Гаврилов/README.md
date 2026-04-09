# Лабораторна робота №6

## Тема
**CSS-анімації та 2D/3D-трансформації**

## Опис
Це навчальний веб-проєкт для демонстрації:
- CSS-анімацій через `@keyframes`;
- 2D-трансформацій (`translate`, `rotate`, `scale`);
- 3D-ефектів (`perspective`, `rotateX`, `rotateY`);
- адаптивної верстки на CSS Grid;
- базової підтримки доступності (reduced motion, tap highlight).

## Технології
- HTML5
- CSS3
- CSS Grid
- Media Queries

## Структура проєкту
```text
№6_AI243_Гаврилов/
  index.html
  style/
    imports.css
    normalize.css
    variables.css
    main.css
    animations.css
    responsive.css
    accessibility.css
    components/
      wrapper.css
      top.css
      menu.css
      card.css
      footer.css
```

## Реалізовано за вимогами
- Шапка сторінки з меню навігації.
- Інформаційні блоки у дві колонки.
- Кілька CSS-анімацій (`header-in`, `menu-breathing`, `card-rise`, `card-loop`, `stripe-wave`).
- 2D та 3D трансформації для інтерактивності.
- Плавні циклічні анімації без різких обривів.
- Адаптивність (`@media (max-width: 860px)`).
- Підтримка `prefers-reduced-motion`.
- Вимкнення tap highlight на сенсорних пристроях у `style/accessibility.css`.

## Підключення стилів
Усі стилі підключаються через єдину точку входу:
- `style/imports.css`

## Як запустити
1. Відкрити файл `index.html` у браузері.
2. Або запустити через розширення типу Live Server у вашому редакторі.

## Автор
**Гаврилов О.В.**

Група: **AI-243**

