# Front End Coding Test

For the assessment we’ll be building out a responsive static html page that matches the designs [here](https://www.figma.com/design/oVC5v6aSlO2MhbQEobgzn2/old-pricing-page?node-id=0-1). If you have any issues with the Figma link please use the images in the [examples](examples/desktop-pricing.jpg) folder.

We have included an empty JavaScript file and set up TailwindCSS in the build process. We want to see you write HTML and JavaScript from scratch as much as possible while using [TailwindCSS](https://tailwindcss.com/docs/utility-first) utility classes for styling. 

Please fork this repository to your personal GitHub account and clone it locally. Once cloned you can start up the development server with:

```
cd front-end
npm install
npm run dev
```

The project has been setup with [TailwindCSS](https://tailwindcss.com/docs/utility-first) and [http-server](https://www.npmjs.com/package/http-server) for local development.  

As you’ll see in the designs, there are three viewport sizes included, we would like to see all three working in your finished submission.

Links and buttons don’t have to lead anywhere, but we would like to see the hamburger menu functioning, this is a chance to showcase some JS skills.

Additionally, for both tablet and mobile viewport sizes, please use JavaScript to add an appropriate class ‘tablet’ or ‘mobile’ to all buttons.

Double and triple check that everything looks good, and feel free to add comments in code or a README file to explain your approach if you’d like.

Email a link back to your repository for us to review. We should be able to clone it locally, run the `npm run dev` command and verify the project. We will most likely use Google Chrome or Firefox to test out the various viewports.

You have 48 hours from now to return this exercise back to us. Good luck, and feel free to reach out with any questions!

# New Relic Frontend Assignment

This project is a responsive website built using **HTML**, **Tailwind CSS**, and **jQuery** for the hamburger menu functionality. It aims to implement a fully responsive design for a pricing plan page with proper layout on mobile, tablet, and desktop devices.

**Check the screenshots folder for implemented design for all mobile, tablet, desktop along with Hamburger screenshot.**


## Table of Contents
- [Project Structure](#project-structure)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [Features](#features)
- [JQuery for Hamburger Menu](#jquery-for-hamburger-menu)
- [Validation](#validation)
- [What is Not Covered](#what-is-not-covered)

## Project Structure.

```plaintext
front-end/
├── screenshorts/
├── src/
│   ├── css/
│   │   └── input.css
│   │   └── output.css
│   ├── fonts/
│   │   └── soehne-buch.woff2
│   │   └── soehne-halbfett.woff2
│   │   └── soehne-kraftig.woff2
│   ├── images/
│   │   └── cards/
│   │   └── logos/
│   ├── js/
│   │   └── index.js
├── index.html
├── package-lock.json
├── package.json
├── tailwind.config.js

```

## Technologies Used

- **NPM Version**: `10.8.1`
- **Tailwind CSS Version**: `v3.4.3`
- **Font Family**:
  - soehne-halbfett (check fonts folder)
  - Sans-serif (Tailwind's default font family)

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/makbulkhan/coding-tests.git
2. Navigate to the project directory:
   ```bash
   cd coding-tests/front-end
3. Install the required NPM packages:
   ```bash
   npm install
4. Build the Tailwind CSS using the following command:
   ```bash
   npm run tailwind
5. Open index.html in a browser to view the project.

## Features

- **Fully Responsive Website**
  - The website is fully responsive and adapts to different screen sizes. Using default breakpoints provided by tailwind  https://tailwindcss.com/docs/responsive-design.
    Mobile: One-column layout.
    Tablet: Two-column layout.
    Desktop: Two-column and Three-column layout (custom widths for footer).
  
- **Tailwind CSS Usage**
  - **Layout and Flexbox:** flex, flex-wrap, justify-center, items-center, etc.
  - **Responsive Grid:** Used grid and grid-cols-* to manage multiple columns.
  - **Responsive Breakpoints:** sm, md, lg, xl breakpoints were used for different screen sizes.
  - **Custom Button:** Tailwind’s utility classes to style buttons like px-4, py-2, bg-blue-500, hover:bg-blue-700, etc.
  - **Typography:** text-5xl, font-semibold, text-gray-900, text-sm, etc.

## JQuery for Hamburger Menu

Hamburger Menu: A jQuery-powered menu for mobile responsiveness.
Here is the jQuery code used for the hamburger menu toggle:
[https://github.com/makbulkhan/coding-tests/blob/main/front-end/src/js/index.js](https://github.com/makbulkhan/coding-tests/blob/main/front-end/src/js/index.js)
This script toggles the visibility of the mobile menu when the hamburger icon is clicked.


## Custom Tailwind Configurations:

Custom colors:
   ```bash
  colors: {
      'clr-free': '#0db0c0',
      'clr-standard': '#0069cc',
      'clr-pro': '#ff8853',
      'clr-enterprise': '#2c2c2c',
      'clr-btn': '#01818f',
      'clr-footer': '#2c2c2c',
      'clr-border': '#e5e7e6',
      'clr-gray': '#faf8f9',
   },
   ```

Custom font-family:
   ```bash
   fontFamily: {
      'soehne': ['Soehne', 'Corbel', 'Arial']
   }
   ```

## Validation

The HTML code was validated using the [W3C Validator](https://validator.w3.org/), and the following errors and warnings were resolved:

Corrected missing closing tags and structure.
Resolved invalid attributes in the markup.
You can also run your own validation using W3C Validator.

## What is Not Covered

Due to the unavailability of the Figma design link, pixel-perfect design alignment is not included. Instead, colors were picked using color picker tools to closely match the expected design.

