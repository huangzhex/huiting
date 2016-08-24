var app=angular.module('myApp',['ngAnimate','ngRoute']);
app.config(function($routeProvider){
	$routeProvider
	.when('/list', {
        controller: 'expCtrl',
        templateUrl: 'list.html'
    })
	.when('/detail/:id', {
        controller: 'DetailCtrl',
        templateUrl: 'detail.html'
    })
	.otherwise({
         redirectTo: '/list'
    });
});
var list=[{id:1,name:'name1'},{id:2,name:'name2'}];
app.controller('expCtrl',function($scope){
	$scope.list=list;
});

app.controller('DetailCtrl',function($scope,$routeParams){
	angular.forEach(list,function(value,key){
		if($routeParams.id==value.id){
			$scope.name=value.name;
		}
	});
});