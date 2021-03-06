/*!
 * V2 Account Services Library
 * http://v2.neflaria.com/
 *
 * Copyright 2010, Jack Lawson
 *
 *Dependencies: jQuery Core, core.js
 */
 
;(function( window, undefined ) {
	
	var MapService = function (){};
	
	MapService = MapService.prototype = {
		ACTION_MOVE: 0,
		ACTION_CHANGEMAP: 1,
		
		ACTION_LOADDATA: 5,
		
		ACTION_BUY: 0,
		ACTION_SELL: 1,
		ACTION_REVIVE: 2,
		ACTION_WITHDRAW: 3,
		ACTION_DEPOSIT: 4,
		ACTION_TRANSFER: 5,
		
		PLACE_TYPE_STORE: 0,
		PLACE_TYPE_SHRINE: 1,
		PLACE_TYPE_BANK: 2,
		
		LOCATION_TYPE_STREET: 0,
		LOCATION_TYPE_WALL: 1,
		LOCATION_TYPE_GUARD: 2,
		LOCATION_TYPE_RESIDENTIAL: 3,
		LOCATION_TYPE_COMMERCE: 4,
		LOCATION_TYPE_MARKET: 5,
		LOCATION_TYPE_BANK: 6,
		LOCATION_TYPE_SHOP: 7,
		LOCATION_TYPE_GRAVEYARD: 8,
		LOCATION_TYPE_SHRINE: 9,
		LOCATION_TYPE_SIEGE: 10,
		LOCATION_TYPE_BAR: 11,
		LOCATION_TYPE_COURT: 12,
		LOCATION_TYPE_WATER: 13,
		LOCATION_TYPE_COLISEUM: 14,
	
		Move: function(x, y, callback){
			var data = { X:x, Y:y };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_MAP, vc.ms.ACTION_MOVE, data);
		},
		
		ChangeMap: function(callback){
			var data = { };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_MAP, vc.ms.ACTION_CHANGEMAP, data);
		},
		
		LoadData: function(mapId, xLow, yLow, xHigh, yHigh, callback){
			var data = { MapId: mapId, XLow: xLow, XHigh: xHigh, YLow: yLow, YHigh: yHigh };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_API, vc.ms.ACTION_LOADDATA, data);
		},

		Buy: function(itemTemplateId, callback){
			var data = { ItemTemplateId: itemTemplateId };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_PLACES, vc.ms.ACTION_BUY, data);
		},
		
		Sell: function(itemId, callback){
			var data = { ItemId: itemId };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_PLACES, vc.ms.ACTION_SELL, data);
		},
		
		Revive: function(callback){
			var data = { };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_PLACES, vc.ms.ACTION_REVIVE, data);
		},
		
		Widthdraw: function(gold, callback){
			var data = { Gold: gold };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_PLACES, vc.ms.ACTION_WITHDRAW, data);
		},
		
		Deposit: function(gold, callback){
			var data = { Gold: gold };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_PLACES, vc.ms.ACTION_DEPOSIT, data);
		},
		
		Transfer: function(gold, name, callback){
			var data = { Gold: gold };
			var requestId = vc.GenerateRequestId();
			vc.CallbackStack[requestId] = {Method: callback, Data: data};
			vc.SendSingleRequest(requestId, vc.TYPE_PLACES, vc.ms.ACTION_TRANSFER, data);
		}
	};
	
	V2Core.MapService = V2Core.ms = MapService;
})(window);
