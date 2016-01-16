var _jenisSuara = "";

var _arrSuara = [];
var _arrSuaraPlayList = [];

// playlist steps
var _SuaraLen = 0;
var _SuaraIdx = 0;

// internal playlist steps
var _plLen = 0;
var _plIdx = 0;

// is antrian loaded
var _isgo = false;

var driverAntrian = ion.sound;

function setJenisSuaraAntrian(jenis) {
    if (_jenisSuara == "") _jenisSuara = jenis;
}

function registerSuaraAntrian(arr, jenisSuara) {
    var suaraTru = [];
    var suaraTru2 = [];
    
    $.each(arr, function(idx, val) {
        if ($.inArray(val, suaraTru) === -1) suaraTru.push(val);
    });
    
    _arrSuaraPlayList.push(arr);
    
    var bLen = _arrSuara.length;
    $.each(suaraTru, function(idx, val) {
        if ($.inArray(val, _arrSuara) === -1) {
            _arrSuara.push(val);
            suaraTru2.push(val);
            bLen++;
        }
    });
    
    driverAntrian({
        sounds: arr,
        path: _jenisSuara,
        preload: true,
        volume: 1,
        multiplay: false,
        ready_callback: cekPreloadAntrian,
        ended_callback: playAntrian,
    });
    if (_arrSuaraPlayList.length <= 1) playAntrian();
}

function cekPreloadAntrian(obj) {
    console.log("loaded : " + obj.name);
    if (obj.name === "noantrian") {
        _isgo = true;
        setTimeout(playAntrian, 500);
    }
}


function playAntrian() {
    if (_isgo) {
        if (_arrSuaraPlayList.length === 0) {
            return false;
        }
        
        _plLen = _arrSuaraPlayList[0].length;
        
        if (_plLen == _plIdx) {
            _arrSuaraPlayList.shift();
            _plIdx = 0;
            playAntrian();
        } else {
            console.log("playlist length : " + _plLen + " , playlist idx : " + _plIdx);
            console.log("sound play : " + _arrSuaraPlayList[0][_plIdx].name);
            driverAntrian.play(_arrSuaraPlayList[0][_plIdx].name);
            _plIdx++;
        }
    }
}

