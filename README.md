# Magento 2 Product Hover Images
The module is designed to display alternative image when mouse cursor is hovering a product in product listing

## Installation

### Using Composer (recommended)
1) Go to your Magento root folder
2) Download the extension using composer:
    ```
    composer require magestyapps/module-hover-image
    ```
3) Run setup commands:

    ```
    php bin/magento setup:upgrade;
    php bin/magento setup:di:compile;
    php bin/magento setup:static-content:deploy -f;
    ```

### Manually
1) Go to your Magento root folder:

    ```
    cd <magento_root>
    ```

2) Copy extension files to *app/code/MagestyApps/HoverImage* folder:
    ```
    git clone https://github.com/MagestyApps/module-web-images.git app/code/MagestyApps/HoverImage
    ```
   ***NOTE:*** *alternatively, you can manually create the folder and copy the extension files there.*

3) Run setup commands:

    ```
    php bin/magento setup:upgrade;
    php bin/magento setup:di:compile;
    php bin/magento setup:static-content:deploy -f;
    ```

## Configuration
### General Settings
You can find the module's settings under:

*Stores > Configuration > MagestyApps Extensions > Product Hover Image*

In the **Hover Effect** setting you can choose the preferred styling for the hover effect. Possible options are:
- Slide Left
- Slide Right
- Slide Up
- Slide Down
- Fade

### Assigning a hover image for a product
In order to select a specific image to be displayed as an alternative image for a product, you should do the following:
1) Edit the product in admin panel and go to the **Media Gallery** section.
2) Select the necessary image
3) In the modal window in the 'Role' field, select the 'Hover Image' option
4) Save the product
5) Flush Magento cache if needed

## Other Extensions
You can find more useful extensions for Magento 2 by visiting [MagestyApps Official Website](https://www.magestyapps.com/)
