var _jenisSuara = "";

var _arrSuara = [];
var _arrSuaraPlayList = [];
var _arrDat = [];

// playlist steps
var _suaraLen = 0;
var _suaraIdx = 0;

// internal playlist steps
var _plLen = 0;
var _plIdx = 0;

// is antrian loaded
var _isgo = false;
var _isplaying = false;


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
        
        if ($.inArray(val.name, _arrSuara) === -1) {
            _arrSuara.push(val.name);
            suaraTru2.push(val);
            bLen++;
        }
    });
    
    /*
    for (var i = 0; i < suaraTru2.length; i++) {
        console.log(suaraTru2[i]);
    }*/
    
    _suaraLen += suaraTru2.length;
    // console.log("registered sound : " + suaraTru2.length + " - total : " + _suaraLen);
    // console.log("sound path : " + _jenisSuara);
    
    if (suaraTru2.length != 0) {
        $.each(suaraTru2, function(idx, val) {
            // console.log ("To be loaded : " + _jenisSuara + val.name + ".mp3");
            var sound = new Howl({
                urls: [_jenisSuara + val.name + ".mp3", _jenisSuara + val.name + ".ogg"],
                onload: cekPreloadAntrian,
                onend: playAntrian,
                autoplay: false,
                loop: false,
                volume: 0.5,
            });
            _arrDat[val.name] = sound;
        });
    }
    
    if (_isgo) {
        if (!_isplaying) playAntrian();
    }
    
}

function cekPreloadAntrian() {
    _suaraIdx++;
    // console.log("Loaded : " + _suaraIdx + " dari " + _suaraLen);
    
    if (_suaraIdx == _suaraLen) {
        _isgo = true;
        playAntrian();
    }
}

/*
function cekPreloadAntrian(obj) {
    console.log("loaded : " + obj.name);
    _suaraIdx++;
    
    if (_suaraLen == _suaraIdx) {
        _isgo = true;
        setTimeout(function() {
            driverAntrian.play("noantrian", {volume: 0});
            //playAntrians();
            setTimeout(function() {
                playAntrians();
            }, 1000);
        }, 1000);
    }
}


*/


function playAntrian() {
    // console.log("Play antrian");
    
    if (_isgo) {
        if (_arrSuaraPlayList.length === 0) {
            return false;
            _isplaying = false;
        }
        _isplaying = true;
        _plLen = _arrSuaraPlayList[0].length;
        
        if (_plLen == _plIdx) {
            _arrSuaraPlayList.shift();
            _plIdx = 0;
            playAntrian();
        } else {
            // console.log("playlist length : " + _plLen + " , playlist idx : " + _plIdx);
            // console.log("sound play : " + _arrSuaraPlayList[0][_plIdx].name);
            _arrDat[_arrSuaraPlayList[0][_plIdx].name].play();
            _plIdx++;
        }
    }
    
}

