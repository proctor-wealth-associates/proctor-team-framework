/*
|--------------------------------------------------------------------------
| Semantic UI - Webpack fix
|--------------------------------------------------------------------------
|
| This script is launched everytime we run `npm install` and changes a few
| paths of the `semantic-ui-less` package in order to make it work with
| webpack. (See: https://www.artembutusov.com/webpack-semantic-ui/).
*/

var fs = require('fs');

// relocate default config
fs.writeFileSync(
    'node_modules/semantic-ui-less/theme.config',
    "@import '../../resources/assets/less/vendor/semantic/theme.config';\n",
    'utf8'
);

// fix well known bug with default distribution
fixFontPath('node_modules/semantic-ui-less/themes/default/globals/site.variables');
fixFontPath('node_modules/semantic-ui-less/themes/flat/globals/site.variables');
fixFontPath('node_modules/semantic-ui-less/themes/material/globals/site.variables');

function fixFontPath(filename) {
    var content = fs.readFileSync(filename, 'utf8');
    var newContent = content.replace(
        "@fontPath  : '../../themes/",
        "@fontPath  : '../../../themes/"
    );
    fs.writeFileSync(filename, newContent, 'utf8');
}
