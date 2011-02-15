(function( window, undefined ) {
	var Maps = new Array();
	
	Maps["MAP_00000000000000000000001"] = { 
		Id: "MAP_00000000000000000000001", 
		Name: "TestZone", 
		PVP: true,
		DimensionX: 5,
		DimensionY: 5,
		MinLevel: 0,
		MaxLevel: 99999999,
		MinAlign: -99999999,
		MaxAlign: 99999999,
		Monsters: {
			"Default": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
			"0": [],
			"1": [],
			"2": []
		},
		Places: []
	}
	
	Maps["MAP_00000000000000000000002"] = { 
		Id: "MAP_00000000000000000000002", 
		Name: "Wilderness", 
		PVP: true,
		DimensionX: 180,
		DimensionY: 100,
		MinLevel: 0,
		MaxLevel: 99999999,
		MinAlign: -99999999,
		MaxAlign: 99999999,
		Monsters: {
			"Default": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
			"0": [],
			"1": [],
			"2": []
		},
		Places: []
	}
	
	Maps["MAP_00000000001296788648248"] = { 
		Id: "MAP_00000000001296788648248", 
		Name: "Parlaor", 
		PVP: true,
		DimensionX: 32,
		DimensionY: 64,
		MinLevel: 0,
		MaxLevel: 99999999,
		MinAlign: -99999999,
		MaxAlign: 99999999,
		Monsters: {
			"8": ["MONS_00000000001297218525596", "MONS_00000000001297218525723", "MONS_00000000001297218525799", "MONS_00000000001297218525818", "MONS_00000000001297218525837", "MONS_00000000001297218525862", "MONS_00000000001297218525881", "MONS_00000000001297218526153", "MONS_00000000001297218526090", "MONS_00000000001297218526107", "MONS_00000000001297218526123", "MONS_00000000001297218526138"], 
			"0": ["MONS_00000000001297218526153", "MONS_00000000001297218526171", "MONS_00000000001297218526192", "MONS_00000000001297218526208", "MONS_00000000001297218526222", "MONS_00000000001297218526236", "MONS_00000000001297218526250", "MONS_00000000001297218526264", "MONS_00000000001297218526283", "MONS_00000000001297218526297", "MONS_00000000001297218526311", "MONS_00000000001297218526326"], 
			"3": ["MONS_00000000001297218526341", "MONS_00000000001297218526362", "MONS_00000000001297218526381", "MONS_00000000001297218526401", "MONS_00000000001297218526429", "MONS_00000000001297218526451", "MONS_00000000001297218526466"], 
			"11": ["MONS_00000000001297218526481", "MONS_00000000001297218526494", "MONS_00000000001297218526507", "MONS_00000000001297218526520", "MONS_00000000001297218526535", "MONS_00000000001297218526548"], 
			"5": ["MONS_00000000001297218526561", "MONS_00000000001297218526863", "MONS_00000000001297218526600", "MONS_00000000001297218526686", "MONS_00000000001297218526947", "MONS_00000000001297218526769", "MONS_00000000001297218526820", "MONS_00000000001297218526834", "MONS_00000000001297218526974"], 
			"9": ["MONS_00000000001297218526863", "MONS_00000000001297218526877", "MONS_00000000001297218526891"], 
			"7": ["MONS_00000000001297218526947", "MONS_00000000001297218526919", "MONS_00000000001297218526934"], 
			"6": ["MONS_00000000001297218526947", "MONS_00000000001297218526961", "MONS_00000000001297218526974"], 
			"14": ["MONS_00000000001297218526987", "MONS_00000000001297218527002", "MONS_00000000001297218527016", "MONS_00000000001297218527031", "MONS_00000000001297218527045", "MONS_00000000001297218527059", "MONS_00000000001297218527074", "MONS_00000000001297218527088", "MONS_00000000001297218527104", "MONS_00000000001297218527118", "MONS_00000000001297218527132"], 
			"2": ["MONS_00000000001297218527147", "MONS_00000000001297218527160", "MONS_00000000001297218527173", "MONS_00000000001297218527186", "MONS_00000000001297218527200", "MONS_00000000001297218527214", "MONS_00000000001297218527229", "MONS_00000000001297218527242", "MONS_00000000001297218527255", "MONS_00000000001297218527268"], 
			"10": ["MONS_00000000001297218527281", "MONS_00000000001297218527296", "MONS_00000000001297218527309", "MONS_00000000001297218527323"], 
			"12": ["MONS_00000000001297218527337", "MONS_00000000001297218527350", "MONS_00000000001297218527367", "MONS_00000000001297218527381", "MONS_00000000001297218527394"] 
		},
		Places: []
	}
	V2Core.Maps = Maps;
})(window);