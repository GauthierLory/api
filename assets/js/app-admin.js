'use strict';
var $ = require('jquery');
$.noConflict();
global.$ = $;
global.jQuery = $;
require('jquery-ui');
require('bootstrap');
require('popper.js');
require('@fortawesome/fontawesome-free');
require('./nav.js');
require('./admin/menu.js');
require( 'datatables.net-bs4' );
require('./modules/datatables');

import('../css/app-admin.css');
import('bootstrap/dist/css/bootstrap.min.css');
import('@fortawesome/fontawesome-free/css/all.min.css');

