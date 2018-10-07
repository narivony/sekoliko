/*
 * Con Full Assets List
 *
 * Usage:
 * var result = conAssets('simpleWeather,d3,nvd3')
 * result ==>
 *  [
 *    '../assets/simpleWeather/jquery.simpleWeather.min.js',
 *    '../bower_components/d3/d3.min.js',
 *    '../assets/nvd3/nv.d3.min.css',
 *    '../assets/nvd3/nv.d3.min.js',
 *    '../assets/nvd3/angular-nvd3.min.js'
 *  ]
 */
window.conAssets = function(get) {
  var list = {
    simpleWeather: ['../bower_components/simpleWeather/jquery.simpleWeather.min.js'],

    sparkline: [
      '../bower_components/jquery.sparkline/dist/jquery.sparkline.min.js',
      'plugins/angularjs-sparkline/angularjs.sparkline.js'
    ],

    flot: [
      '../bower_components/flot/jquery.flot.js',
      '../bower_components/flot/jquery.flot.time.js',
      '../bower_components/flot/jquery.flot.pie.js',
      '../bower_components/flot/jquery.flot.categories.js',
      '../bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js',
      'plugins/angularjs-flot/angular-flot.js'
    ],

    nvd3: [
      '../bower_components/d3/d3.min.js',
      '../bower_components/nvd3/build/nv.d3.min.css',
      '../bower_components/nvd3/build/nv.d3.min.js',
      'plugins/angularjs-nvd3/angular-nvd3.min.js'
    ],

    rickshaw: [
      '../bower_components/d3/d3.min.js',
      '../bower_components/rickshaw/rickshaw.min.css',
      '../bower_components/rickshaw/rickshaw.min.js',
      'plugins/angularjs-rickshaw/rickshaw-angularjs.js'
    ],

    squire: [
      '../assets/_con/squire/squire-ui.css',
      '../bower_components/squire/build/squire.js',
      '../assets/_con/squire/squire-ui.js'
    ],

    markitup: [
      '../assets/_con/markitup/skins/_con/style.css',
      '../bower_components/markitup-1x/markitup/sets/default/style.css',
      '../bower_components/markitup-1x/markitup/sets/default/set.js',
      '../bower_components/markitup-1x/markitup/jquery.markitup.js'
    ],

    ckeditor: ['../bower_components/ckeditor/ckeditor.js'],

    select2: [
      '../bower_components/select2/dist/css/select2.min.css',
      '../bower_components/select2/dist/js/select2.full.min.js'
    ],

    tagsinput: [
      '../bower_components/jquery.tagsinput/src/jquery.tagsinput.css',
      '../bower_components/jquery.tagsinput/src/jquery.tagsinput.js'
    ],

    dropzone: [
      '../bower_components/dropzone/dist/min/dropzone.min.css',
      '../bower_components/dropzone/dist/min/dropzone.min.js'
    ],

    clockpicker:[
      '../bower_components/clockpicker/dist/jquery-clockpicker.min.css',
      '../bower_components/clockpicker/dist/jquery-clockpicker.min.js'
    ],

    pikaday: [
      '../bower_components/pikaday/css/pikaday.css',
      '../bower_components/pikaday/pikaday.js',
      '../bower_components/pikaday/plugins/pikaday.jquery.js'
    ],

    spectrum: [
      '../bower_components/spectrum/spectrum.css',
      '../bower_components/spectrum/spectrum.js'
    ],

    inputmask: ['../bower_components/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js'],

    parsley: ['../bower_components/parsleyjs/dist/parsley.min.js'],
    
    gmaps: ['../bower_components/gmaps/gmaps.min.js'],

    jvectormap: [
      '../assets/jquery-jvectormap/jquery-jvectormap.css',
      '../assets/jquery-jvectormap/jquery-jvectormap.min.js',
      '../assets/jquery-jvectormap/jquery-jvectormap-world-mill-en.js',
      '../assets/jquery-jvectormap/gdp-data.js',
      'plugins/angularjs-jvectormap/angularjs-jvectormap.js'
    ],

    dataTables: [
      '../bower_components/datatables/media/js/jquery.dataTables.min.js',
      '../bower_components/datatables-tabletools/js/dataTables.tableTools.js',
      '../bower_components/datatables-scroller/js/dataTables.scroller.js',
      ' plugins/angularjs-dataTables/angular-datatables.min.js'
    ],

    fullcalendar: [
      '../bower_components/fullcalendar/dist/fullcalendar.min.css',
      '../bower_components/moment/min/moment.min.js',
      '../bower_components/jquery-ui/jquery-ui.min.js',
      '../bower_components/fullcalendar/dist/fullcalendar.min.js'
    ],

    sortable: ['../bower_components/Sortable/Sortable.min.js'],

    wowjs: ['../bower_components/wow/dist/wow.min.js'],

    animatecss: ['../bower_components/animate.css/animate.min.css'],

    photoswipe: [
      '../bower_components/photoswipe/dist/default-skin/default-skin.css',
      '../bower_components/photoswipe/dist/photoswipe.css',
      '../bower_components/photoswipe/dist/photoswipe.min.js',
      '../bower_components/photoswipe/dist/photoswipe-ui-default.min.js'
    ],

    isotope: ['../bower_components/isotope/dist/isotope.pkgd.min.js'],

    videojs: [
      '../bower_components/video.js/dist/video-js/video-js.min.css',
      '../bower_components/video.js/dist/video-js/video.js',
      '../bower_components/videojs-youtube/dist/vjs.youtube.js',
      '../bower_components/videojs-vimeo/vjs.vimeo.js'
    ],

    nestable: [
      '../bower_components/nestable/jquery.nestable.js'
    ],

    jstree: [
      '../assets/_con/jstree/style.min.css',
      '../bower_components/jstree/dist/jstree.min.js'
    ]
  };

  // return result array
  var get = get.split(',');
  var result = [];
  for(var k in get) {
    if(typeof list[ get[k] ] !== 'undefined') {
      for(var n in list[ get[k] ]) {
        result.push( list[ get[k] ][n] );
      }
    }
  }

  return result;
}





/*
 * Con AngularJS Version
 */
var conAngular = angular.module("conAngular", [
  "ui.router", 
  "ui.materialize", 
  "oc.lazyLoad",  
  "ngSanitize"
]); 

// Config ocLazyLoader
conAngular.config(['$ocLazyLoadProvider', function($ocLazyLoadProvider) {
  $ocLazyLoadProvider.config({
    // lazy load config
  });
}]);


// Global Options
conAngular.factory('settings', ['$rootScope', function($rootScope) {
  var settings = {
    rtl: false, // rtl mode
    boxed: false, // boxed layout
    navbar: {
      dark:   false, // dark color scheme
      static: false, // static
      under:  false  // navbar under sidebar
    },
    sidebar: {
      hideToSmall:     true,    // hide to small sidebar
      static:          false,   // static
      gestures:        true,    // gestures support
      light:           false,   // light color scheme
      overlapContent:  false,   // Overlay content when opened
      effect:          'shrink' // show effect: [shrink, push, overlay]
    },
    chat: {
      light: false // light color scheme
    }
  };

  $rootScope.settings = settings;

  return settings;
}]);



// App Controller
conAngular.controller('AppController', ['$scope', '$rootScope', '$state', function($scope, $rootScope, $state) {
  $scope.$on('$viewContentLoaded', function() {
    // init plugins
    conApp.initPlugins();
    conApp.initCards();
    conApp.initCardTodo();
    conApp.initCardWeather();
  });
}]);

// Navbar Controller
conAngular.controller('NavbarController', ['$scope', function($scope) {
  $scope.$on('$includeContentLoaded', function() {
  });
}]);

// Sidebar Controller
conAngular.controller('SidebarController', ['$scope', function($scope) {
  $scope.$on('$includeContentLoaded', function() {
    conApp.initSidebar();
  });
}]);

// Search Controller
conAngular.controller('SearchController', ['$scope', function($scope) {
  $scope.$on('$includeContentLoaded', function() {
    conApp.initSearchBar();
  });
}]);

// Chat Controller
conAngular.controller('ChatController', ['$scope', function($scope) {
  $scope.$on('$includeContentLoaded', function() {
    conApp.initChat();
  });
}]);


// Setup Rounting For All Pages
conAngular.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
  // Redirect any unmatched url
  $urlRouterProvider.otherwise("/dashboard.html");  
  
  // pages
  $stateProvider
    // Dashboard
    .state('/dashboard', {
      url: "/dashboard.html",
      templateUrl: "tpl/dashboard.html",
      controller: "DashboardController",
      data: {
        pageTitle: 'Admin Dashboard with Material Design',
        crumbs: [{
            title: '<i class="fa fa-home"></i> Home',
            href: '#'
          }, {
            title: 'Dashboard',
            href: '#/dashboard.html'
          }]
      },
      resolve: {
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'conAngular',
            insertBefore: '#ngInsertBefore', // load the above css files before a LINK element with this ID. Dynamic CSS files must be loaded between core and theme css files
            files: conAssets('simpleWeather,sortable')
          }, {
            name: 'conAngular',
            serie: true, // used for synchronous load chart scripts
            insertBefore: '#ngInsertBefore',
            files: conAssets('sparkline,flot,rickshaw,jvectormap')
          }]);
        }]
      }
    })

    // Dashboard v1
    .state('/dashboard-v1', {
      url: "/dashboard-v1.html",
      templateUrl: "tpl/dashboard-v1.html",
      controller: "DashboardV1Controller",
      data: {
        pageTitle: 'Dashboard v1',
        crumbs: [{
            title: '<i class="fa fa-home"></i> Home',
            href: '#'
          }, {
            title: 'Dashboard v1',
            href: '#/dashboard-v1.html'
          }]
      },
      resolve: {
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'conAngular',
            insertBefore: '#ngInsertBefore',
            files: conAssets('simpleWeather,sortable')
          }, {
            name: 'conAngular',
            serie: true,
            insertBefore: '#ngInsertBefore',
            files: conAssets('flot,nvd3')
          }]);
        }]
      }
    })

    // Angular Options
    .state('/angular-settings', {
      url: "/angular-settings.html",
      templateUrl: "tpl/angular-settings.html",
      controller: "PageController",
      data: {
        pageTitle: 'Angular Settings',
        crumbs: [{
            title: '<i class="fa fa-home"></i> Home',
            href: '#'
          }, {
            title: 'Angular Settings',
            href: '#/angular-settings.html'
          }]
      }
    })

    // Widgets
    .state('/widgets', {
      url: "/widgets.html",
      templateUrl: "tpl/widgets.html",
      controller: "PageController",
      data: {
        pageTitle: 'Widgets',
        crumbs: [{
            title: '<i class="fa fa-home"></i> Home',
            href: '#'
          }, {
            title: 'Dashboard',
            href: '#/dashboard.html'
          }, {
            title: 'Widgets',
            href: '#/widgets.html'
          }]
      },
      resolve: {
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'conAngular',
            insertBefore: '#ngInsertBefore',
            files: conAssets('sparkline,simpleWeather')
          }]);
        }]
      }
    })

    // Forms Base
    .state('/forms-base', {
      url: "/forms-base.html",
      templateUrl: "tpl/forms-base.html",
      controller: "PageController",
      data: {
        pageTitle: 'Base Forms',
        crumbs: [{
            title: '<i class="fa fa-home"></i> Home',
            href: '#'
          }, {
            title: 'Dashboard',
            href: '#/dashboard.html'
          }, {
            title: 'Forms',
            href: '#'
          }, {
            title: 'Base Forms',
            href: '#/forms-base.html'
          }]
      }
    })

    // Forms Advanced
    .state('/forms-advanced', {
      url: "/forms-advanced.html",
      templateUrl: "tpl/forms-advanced.html",
      controller: "PageController",
      data: {
        pageTitle: 'Advanced Forms',
        crumbs: [{
            title: '<i class="fa fa-home"></i> Home',
            href: '#'
          }, {
            title: 'Dashboard',
            href: '#/dashboard.html'
          }, {
            title: 'Forms',
            href: '#'
          }, {
            title: 'Advanced Forms',
            href: '#/forms-advanced.html'
          }]
      },
      resolve: {
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'conAngular',
            insertBefore: '#ngInsertBefore',
            files: conAssets('select2,dropzone,tagsinput,clockpicker,spectrum,inputmask,parsley')
          }, {
            name: 'conAngular',
            serie: true,
            insertBefore: '#ngInsertBefore',
            files: conAssets('pikaday')
          }]);
        }]
      }
    })

    // Forms Validation
    .state('/forms-validation', {
      url: "/forms-validation.html",
      templateUrl: "tpl/forms-validation.html",
      controller: "PageController",
      data: {
        pageTitle: 'Forms Validation',
        crumbs: [{
            title: '<i class="fa fa-home"></i> Home',
            href: '#'
          }, {
            title: 'Dashboard',
            href: '#/dashboard.html'
          }, {
            title: 'Forms',
            href: '#'
          }, {
            title: 'Validation',
            href: '#/forms-validation.html'
          }]
      },
      resolve: {
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'conAngular',
            insertBefore: '#ngInsertBefore',
            files: conAssets('parsley')
          }]);
        }]
      }
    })

    // Forms Editors
    .state('/forms-editors', {
      url: "/forms-editors.html",
      templateUrl: "tpl/forms-editors.html",
      controller: "PageController",
      data: {
        pageTitle: 'Editors',
        crumbs: [{
            title: '<i class="fa fa-home"></i> Home',
            href: '#'
          }, {
            title: 'Dashboard',
            href: '#/dashboard.html'
          }, {
            title: 'Forms',
            href: '#'
          }, {
            title: 'Editors',
            href: '#/forms-editors.html'
          }]
      },
      resolve: {
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'conAngular',
            insertBefore: '#ngInsertBefore',
            files: conAssets('markitup,ckeditor')
          }]);
        }]
      }
    })

    // Mail Inbox
    .state('/mail-inbox', {
      url: "/mail-inbox.html",
      templateUrl: "tpl/mail-inbox.html",
      controller: "PageController",
      data: {
        pageTitle: 'Mail Inbox',
        crumbs: [{
            title: '<i class="fa fa-home"></i> Home',
            href: '#'
          }, {
            title: 'Dashboard',
            href: '#/dashboard.html'
          }, {
            title: 'Mail',
            href: '#'
          }, {
            title: 'Inbox',
            href: '#/mail-inbox.html'
          }]
      }
    })

    // Mail View
    .state('/mail-view', {
      url: "/mail-view.html",
      templateUrl: "tpl/mail-view.html",
      controller: "PageController",
      data: {
        pageTitle: 'Mail View',
        crumbs: [{
            title: '<i class="fa fa-home"></i> Home',
            href: '#'
          }, {
            title: 'Dashboard',
            href: '#/dashboard.html'
          }, {
            title: 'Mail',
            href: '#'
          }, {
            title: 'View',
            href: '#/mail-view.html'
          }]
      }
    })

    // Mail Compose
    .state('/mail-compose', {
      url: "/mail-compose.html",
      templateUrl: "tpl/mail-compose.html",
      controller: "PageController",
      data: {
        pageTitle: 'Mail Compose',
        crumbs: [{
            title: '<i class="fa fa-home"></i> Home',
            href: '#'
          }, {
            title: 'Dashboard',
            href: '#/dashboard.html'
          }, {
            title: 'Mail',
            href: '#'
          }, {
            title: 'Compose',
            href: '#/mail-compose.html'
          }]
      },
      resolve: {
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'conAngular',
            insertBefore: '#ngInsertBefore',
            files: conAssets('ckeditor')
          }]);
        }]
      }
    })

    // Charts Flot
    .state('/charts-flot', {
      url: "/charts-flot.html",
      templateUrl: "tpl/charts-flot.html",
      controller: "ChartFlotController",
      data: {
        pageTitle: 'Flot Charts',
        crumbs: [{
            title: '<i class="fa fa-home"></i> Home',
            href: '#'
          }, {
            title: 'Dashboard',
            href: '#/dashboard.html'
          }, {
            title: 'Charts',
            href: '#'
          }, {
            title: 'Flot',
            href: '#/charts-flot.html'
          }]
      },
      resolve: {
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'conAngular',
            serie: true,
            insertBefore: '#ngInsertBefore',
            files: conAssets('flot')
          }]);
        }]
      }
    })

    // Charts NVD3
    .state('/charts-nvd3', {
      url: "/charts-nvd3.html",
      templateUrl: "tpl/charts-nvd3.html",
      controller: "ChartNVD3Controller",
      data: {
        pageTitle: 'NVD3 Charts',
        crumbs: [{
            title: '<i class="fa fa-home"></i> Home',
            href: '#'
          }, {
            title: 'Dashboard',
            href: '#/dashboard.html'
          }, {
            title: 'Charts',
            href: '#'
          }, {
            title: 'NVD3',
            href: '#/charts-nvd3.html'
          }]
      },
      resolve: {
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'conAngular',
            serie: true,
            insertBefore: '#ngInsertBefore',
            files: conAssets('nvd3')
          }]);
        }]
      }
    })

    // Charts Rickshaw
    .state('/charts-rickshaw', {
      url: "/charts-rickshaw.html",
      templateUrl: "tpl/charts-rickshaw.html",
      controller: "ChartRickshawController",
      data: {
        pageTitle: 'Rickshaw Charts',
        crumbs: [{
            title: '<i class="fa fa-home"></i> Home',
            href: '#'
          }, {
            title: 'Dashboard',
            href: '#/dashboard.html'
          }, {
            title: 'Charts',
            href: '#'
          }, {
            title: 'Rickshaw',
            href: '#/charts-rickshaw.html'
          }]
      },
      resolve: {
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'conAngular',
            serie: true,
            insertBefore: '#ngInsertBefore',
            files: conAssets('rickshaw')
          }]);
        }]
      }
    })

    // Charts Sparkline
    .state('/charts-sparkline', {
      url: "/charts-sparkline.html",
      templateUrl: "tpl/charts-sparkline.html",
      controller: "ChartSparkController",
      data: {
        pageTitle: 'Sparkline Charts',
        crumbs: [{
            title: '<i class="fa fa-home"></i> Home',
            href: '#'
          }, {
            title: 'Dashboard',
            href: '#/dashboard.html'
          }, {
            title: 'Charts',
            href: '#'
          }, {
            title: 'Sparkline',
            href: '#/charts-sparkline.html'
          }]
      },
      resolve: {
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'conAngular',
            serie: true,
            insertBefore: '#ngInsertBefore',
            files: conAssets('sparkline')
          }]);
        }]
      }
    })

    // Google Maps
    .state('/maps-google', {
      url: "/maps-google.html",
      templateUrl: "tpl/maps-google.html",
      controller: "PageController",
      data: {
        pageTitle: 'Google Maps',
        crumbs: [{
            title: '<i class="fa fa-home"></i> Home',
            href: '#'
          }, {
            title: 'Dashboard',
            href: '#/dashboard.html'
          }, {
            title: 'Maps',
            href: '#'
          }, {
            title: 'Google',
            href: '#/maps-google.html'
          }]
      },
      resolve: {
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'conAngular',
            insertBefore: '#ngInsertBefore',
            files: conAssets('gmaps')
          }]);
        }]
      }
    })

    // Vector Maps
    .state('/maps-vector', {
      url: "/maps-vector.html",
      templateUrl: "tpl/maps-vector.html",
      controller: "MapsVectorController",
      data: {
        pageTitle: 'Vector Maps',
        crumbs: [{
            title: '<i class="fa fa-home"></i> Home',
            href: '#'
          }, {
            title: 'Dashboard',
            href: '#/dashboard.html'
          }, {
            title: 'Maps',
            href: '#'
          }, {
            title: 'Vector',
            href: '#/maps-vector.html'
          }]
      },
      resolve: {
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'conAngular',
            serie: true,
            insertBefore: '#ngInsertBefore',
            files: conAssets('jvectormap')
          }]);
        }]
      }
    })

    // Data Tables
    .state('/data-tables', {
      url: "/data-tables.html",
      templateUrl: "tpl/data-tables.html",
      controller: "DatatablesController",
      data: {
        pageTitle: 'Data Tables',
        crumbs: [{
            title: '<i class="fa fa-home"></i> Home',
            href: '#'
          }, {
            title: 'Dashboard',
            href: '#/dashboard.html'
          }, {
            title: 'Data Tables',
            href: '#/data-tables.html'
          }]
      },
      resolve: {
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'conAngular',
            serie: true,
            insertBefore: '#ngInsertBefore',
            files: conAssets('dataTables')
          }]);
        }]
      }
    })

}]);

/* Init global settings and run the app */
conAngular.run(["$rootScope", "settings", "$state", function($rootScope, settings, $state) {
  $rootScope.$state = $state; // state to be accessed from view
}]);