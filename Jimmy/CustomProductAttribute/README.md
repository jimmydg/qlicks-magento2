# Custom product attribute module

Show custom product attribute data in a separate tab on the product page.

## Installation

Enable plugin:  
`bin/magento module:enable Jimmy_CustomProductAttribute`  
Apply database updates:  
`bin/magento setup:upgrade`

## Configuration

- Access the backend
- Go to `Stores > Configuration > CUSTOM PRODUCT ATTRIBUTE`
- `Show in tab?` will either display the attribute in the tab, or not show it.
    - Note to Qlicks devs: Deliberately put this logic in here, as it wasn't clear which layout is meant by "
      container2". If you could let me know what is meant by that, I'll add it :-)

## Product config

- Go to an item in the backend
- If the database update was successful, you should see a ` Jimmy Custom Attribute` field.
- Enter text, html tags etc.. in here

Open the product in the FE and you will be greeted by a new tab `Custom Tab`, which contains the contents of the product
attribute.
