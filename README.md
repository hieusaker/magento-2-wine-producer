# Mage2 Module Hieunv WineProducer

    ``hieunv/module-wineproducer``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
HieuNV Magento Developer

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Hieunv`
 - Enable the module by running `php bin/magento module:enable Hieunv_WineProducer`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

## Producer Importing
### Importing producer to producer table: "hieunv_wine_producer". Only support csv format.
- 1. Upload csv to folder var/import/producer/producer.csv
- 2. Upload images to folder var/import/producer/images and specific image name in csv file
- 3. In magento Root folder, run command: php bin/magento hieunv:producer:import 



    
