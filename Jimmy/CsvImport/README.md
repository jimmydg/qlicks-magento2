# CsvImport module

CSV Import module to connect product links (Upsell, cross-sell and related) data to existing products.

## Installation

Enable plugin  
`bin/magento module:enable Jimmy_CsvImport`

## Usage

- Login to the backend
- In the menu on the left side, click on `Csv Import` > `Upload CSV`
- Select a csv file and click on Import csv file

Any errors will be displayed in the message box at the top. On succesfull upload, a `Updated products successfully.`
message will be displayed.

### Example csv file

```
sku,upsell_skus,crossell_skus,related_skus
24-MB01,24-MB04,24-MB03,24-MB05
```

