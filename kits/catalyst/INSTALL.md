# Getting started

Thais kit provides ready-to-use and fully-customizable UI Twig components based on [Catalyst](https://catalyst.tailwindui.com/) components's **design**.

## Requirements

This kit requires TailwindCSS to work:
- If you use Symfony AssetMapper, you can install TailwindCSS with the [TailwindBundle](https://symfony.com/bundles/TailwindBundle/current/index.html),
- If you use Webpack Encore, you can follow the [TailwindCSS installation guide for Symfony](https://tailwindcss.com/docs/installation/framework-guides/symfony)

## Installation

Catalyst using [Inter](https://rsms.me/inter/) to ensure that the components look the same in all browsers and operating systems. The easiest way is to add it via the CDN:

```html
<link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
```

Modify the file `assets/styles/app.css` with the following content:

```css
@import "tailwindcss";

@theme {
    --font-sans: Inter, sans-serif;
    --font-sans--font-feature-settings: 'cv11';
}
```
