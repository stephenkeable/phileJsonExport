# phileJsonExport

## Usage 

Download repo to `/plugins/StephenKeable/jsonexport`

Add this line to your root `config.php` file

`'StephenKeable\\jsonExport' => array('active' => true)`

Within the `$config['plugins'] = array( ... );` array.

Then visit `/pages.json` to see full JSON export of all pages.

## Reason for building

We used this plugin to generate a JSON object to upload to www.algolia.com to build an initial index for a site search.
