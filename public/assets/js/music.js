document.ondblclick = function (e) {
    e.preventDefault();
}

document.addEventListener('gesturestart', function (e) {
    e.preventDefault();
    document.body.style.zoom = 1.0;
});

document.addEventListener('gesturechange', function (e) {
    e.preventDefault();
    document.body.style.zoom = 1.0;
});

document.addEventListener('gestureend', function (e) {
    e.preventDefault();
    document.body.style.zoom = 1.0;
});

window.mobileCheck = function () {
    let check = false;
    (function (a) {
        if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;
    })(navigator.userAgent || navigator.vendor || window.opera);
    return check;
};

(function ($) {
    "use strict";
    var wavesurfer;
    var id_container_sel;
    var interval_nowplayng;
    var current_song = '';
    var songs_array, all_songs_array, albums_array;
    var xhr_now;
    var search_index = 0;
    var current_option = {
        waveform_width: 3,
        search: true,
        albums: true,
        cache: true
    }

    window.init_smp = function (id_container, directory = 'songs', option) {
        id_container_sel = id_container;
        try {
            current_option.waveform_width = option.waveform_width;
        } catch (e) {
        }
        try {
            current_option.search = option.search;
        } catch (e) {
        }
        try {
            current_option.cache = option.cache;
        } catch (e) {
        }
        try {
            current_option.albums = option.albums;
        } catch (e) {
        }
        $('#' + id_container).html(`
        <div id="loading">
            <div>
                <img src="/assets/img/blue_loading.gif">
                <h2>INITIALIZING MUSIC PLAYER</h2>
            </div>
        </div>
        <div id="blue-playlist-container">
            <div id="amplitude-player">
                <div id="amplitude-left">
                    <img class="main-cover" data-amplitude-song-info="cover_art_url"/>
                    <div id="player-left-bottom">
                        <div id="time-container">
                            <span class="current-time">
                                <span class="amplitude-current-minutes"></span>:<span class="amplitude-current-seconds"></span>
                            </span>
                            <div id="progress-container">
                                <input type="range" class="amplitude-song-slider"/>
                                <progress id="song-played-progress" class="amplitude-song-played-progress"></progress>
                                <progress id="song-buffered-progress" class="amplitude-buffered-progress" value="0"></progress>
                            </div>
                            <span class="duration">
                                <span class="amplitude-duration-minutes"></span>:<span class="amplitude-duration-seconds"></span>
                            </span>
                        </div>
                        <div id="waveform"></div>
                        <div id="control-container">
                            <div id="repeat-container">
                                <div class="amplitude-repeat" id="repeat"></div>
                                <div class="amplitude-shuffle amplitude-shuffle-off" id="shuffle"></div>
                            </div>
                            <div id="central-control-container">
                                <div id="central-controls">
                                    <div class="amplitude-prev" id="previous"></div>
                                    <div class="amplitude-play-pause" id="play-pause">
                                        <img class="loading_song" src="/assets/img/blue_loading.gif" />
                                    </div>
                                    <div class="amplitude-next" id="next"></div>
                                </div>
                            </div>
                            <div id="volume-container">
                                <div class="volume-controls">
                                    <div class="amplitude-mute amplitude-not-muted"></div>
                                    <input type="range" class="amplitude-volume-slider"/>
                                    <div class="ms-range-fix"></div>
                                </div>
                                <div class="amplitude-shuffle amplitude-shuffle-off" id="shuffle-right"></div>
                            </div>
                        </div>
                        <div id="album-cover-mobile">
                            <img data-amplitude-song-info="cover_art_url"/>
                        </div>
                        <div id="meta-container">
                            <span data-amplitude-song-info="name" class="song-name"></span>
                            <div class="song-artist-album">
                                <span data-amplitude-song-info="artist"></span>
                                <span data-amplitude-song-info="album"></span>
                            </div>
                        </div>
                        <div id="control-container-mobile">
                            <div class="volume-controls">
                                <div class="amplitude-mute amplitude-not-muted"></div>
                                <input type="range" class="amplitude-volume-slider"/>
                                <div class="ms-range-fix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="amplitude-right">
                    <div id="selector">
                        <div onclick="view_songs();" id="songs_btn" class="active">
                            <i class="fa-solid fa-music"></i>&nbsp;&nbsp;SONGS
                        </div>
                        <div onclick="view_albums();" id="albums_btn">
                            <i class="fa-solid fa-record-vinyl"></i>&nbsp;&nbsp;ALBUMS
                        </div>
                    </div>
                    <div class="search_div"></div>

                    <div id="albums_list"></div>
                    <div id="songs_list"></div>

                    <div class="doctor-controls">
                    <h5>Control patient music player</h5>
                    <button class="btn btn-primary" onclick="controlMusic('start')"><i class="fas fa-play"></i> Play</button>
                    <button class="btn btn-primary" onclick="controlMusic('pause')"><i class="fas fa-pause"></i> Pause</button>
                    <button class="btn btn-primary" onclick="controlMusic('change')"><i class="fas fa-sync-alt"></i> Change Track</button>
                    </div>
                </div>
            </div>
        </div>
    `).promise().done(function () {
        fetch_songs(id_container, directory);
    });

    }

    window.view_songs = function () {
        $('#songs_btn').addClass('active');
        $('#albums_btn').removeClass('active');
        $('#songs_list').show();
        $('#albums_list').hide();
        if (current_option.search) {
            $('.search_div').show();
        }
    }

    window.view_albums = function () {
        $('#albums_btn').addClass('active');
        $('#songs_btn').removeClass('active');
        $('#songs_list').hide();
        $('#albums_list').show();
        $('.search_div').hide();
    }

    window.filter_album = function (album_id) {
        search_index++;
        Amplitude.stop();
        $('.album').removeClass('active');
        $('.album[data-id="' + album_id + '"]').addClass('active');
        songs_array = [];
        $.each(all_songs_array, function (index, song) {
            if (song.album_id == album_id || album_id == 'all') {
                songs_array.push(song);
            }
        });
        $('#' + id_container_sel + ' #amplitude-right #songs_list').empty();
        $('.search_div').empty();
        $('#amplitude-right #songs_list').searchable('destroy');
        parse_songs_player(id_container_sel, songs_array, albums_array,false);
        view_songs();
    }

    function parse_songs_player(id_container, songs_array, albums_array, first_time) {
        if (current_option.albums) {
            if (current_option.search) {
                $('.search_div').css('margin-top', '50px');
                $('div#amplitude-right #songs_list').css('padding-top', '50px');
            } else {
                $('.search_div').hide();
                $('div#amplitude-right #songs_list').css('padding-top', '0px');
            }
            if(first_time) {
                var html_albums = "<div data-id='all' onclick=\"filter_album('all');\" class=\"album all-album active\">\n" +
                    "        <img src=\"data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==\">\n" +
                    "        <p class='album_name'>All the songs</p>\n" +
                    "        <p class='artist_name'>.</p>\n" +
                    "    </div>";
                $.each(albums_array, function (index, album) {
                    html_albums += "<div data-id='" + album.album_id + "' onclick=\"filter_album('" + album.album_id + "');\" class=\"album\">\n" +
                        "        <img src=\"" + album.image + "\">\n" +
                        "        <p class='album_name'>" + album.album + "</p>\n" +
                        "        <p class='artist_name'>" + ((album.artists.length == 1) ? album.artists[0] : 'Various Artists') + "</p>\n" +
                        "    </div>";
                });
                $('#' + id_container + ' #amplitude-right #albums_list').html(html_albums).promise().done(function () {

                });
            }
        } else {
            if (current_option.search) {
                $('.search_div').css('margin-top', '0px');
                $('div#amplitude-right #selector').hide();
                $('div#amplitude-right #songs_list').css('padding-top', '50px');
            } else {
                $('.search_div').hide();
                $('div#amplitude-right #selector').hide();
                $('div#amplitude-right #songs_list').css('padding-top', '0px');
            }
        }
        var html_songs = '';
        $.each(songs_array, function (index, song) {
            if (song.live) {
                var duration = 'live';
            } else {
                var duration = song.duration;
            }
            html_songs += "<div class=\"song amplitude-song-container amplitude-play-pause\" data-album-id='" + song.album_id + "' data-amplitude-song-index=\"" + index + "\">\n" +
                "                <div class=\"song-now-playing-icon-container\">\n" +
                "                    <div class=\"play-button-container\">\n" +
                "                    </div>\n" +
                "                    <img class=\"now-playing\" src=\"/assets/img/now-playing.svg\"/>\n" +
                "                </div>\n" +
                "                <div class=\"song-meta-data\">\n" +
                "                    <span class=\"song-title\">" + song.name + "</span>\n" +
                "                    <span class=\"song-artist\">" + song.artist + "</span>\n" +
                "                </div>\n" +
                "                <span class=\"bandcamp-link\">\n" +
                "                    <img class=\"bandcamp-grey\" style=\"width:24px;height:24px;\" src=\"" + song.cover_art_url + "\">\n" +
                "                </span>\n" +
                "                <span class=\"song-duration\">" + duration + "</span>\n" +
                "            </div>";
        });
        $('.search_div').html('<input placeholder="Search..." id="search_' + search_index + '" class="search_input" type="text" />');
        $('#' + id_container + ' #amplitude-right #songs_list').html(html_songs).promise().done(function () {
            $('#amplitude-right #songs_list').searchable({
                selector: '.song',
                childSelector: 'div',
                searchField: '#search_' + search_index,
                searchType: 'default',
                clearOnLoad: true
            });
            init_music_player(id_container, songs_array);
        });
    }

    window.fetch_songs = function (id_container, directory) {
        $.ajax({
            url: fetchTherapiesUrl, //'/assets/ajax/fetch_songs.php',//'/fetch-therapies',
            type: "GET",
            async: true,
            timeout: 99999,
            data: {
                directory: directory,
                cache: (current_option.cache) ? 1 : 0
            },
            success: function (json) {
                var rsp = JSON.parse(json);
                all_songs_array = songs_array = rsp.songs;
                //albums_array = rsp.albums;
                parse_songs_player(id_container, songs_array, albums_array, true);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('error');
            }
        });
    }

    function update_nowplayng(url, type) {
        try {
            xhr_now.abort();
        } catch (e) {
        }
        xhr_now = $.ajax({
            url: "ajax/get_currentsong.php",
            type: "POST",
            timeout: 9000,
            data: {
                type: type,
                url: url
            },
            success: function (result) {
                if (result != '') {
                    $('.song-name').html(result);
                    if (current_song != result) {
                        current_song = result;
                        refreshArtwork(result);
                    }
                }
            }
        });
    }

    function refreshArtwork(title) {
        $.ajax({
            url: 'https://itunes.apple.com/search',
            data: {
                term: title,
                media: 'music'
            },
            dataType: 'jsonp',
            success: function (json) {
                if (json.results.length === 0) {
                    var currentIndex = Amplitude.getActiveIndex();
                    $('.main-cover').attr('src', songs_array[currentIndex].cover_art_url);
                    $('#amplitude-left').css('background-image', 'url(\'' + songs_array[currentIndex].cover_art_url + '\')');
                    return;
                }
                var artworkURL = json.results[0].artworkUrl100;
                artworkURL = artworkURL.replace('100x100', '600x600');
                $('.main-cover').attr('src', artworkURL);
                $('#amplitude-left').css('background-image', 'url(\'' + artworkURL + '\')');
            }
        });
    }

    function init_music_player(id_container, songs_array) {
        let songElements = document.getElementsByClassName('song');

        for (var i = 0; i < songElements.length; i++) {
            songElements[i].addEventListener('mouseover', function () {
                this.style.backgroundColor = '#00A0FF';
                this.querySelectorAll('.song-meta-data .song-title')[0].style.color = '#FFFFFF';
                this.querySelectorAll('.song-meta-data .song-artist')[0].style.color = '#FFFFFF';
                if (!this.classList.contains('amplitude-active-song-container')) {
                    this.querySelectorAll('.play-button-container')[0].style.display = 'block';
                }
                this.querySelectorAll('.song-duration')[0].style.color = '#FFFFFF';
            });

            songElements[i].addEventListener('mouseout', function () {
                this.style.backgroundColor = '#FFFFFF';
                this.querySelectorAll('.song-meta-data .song-title')[0].style.color = '#272726';
                this.querySelectorAll('.song-meta-data .song-artist')[0].style.color = '#607D8B';
                this.querySelectorAll('.play-button-container')[0].style.display = 'none';
                this.querySelectorAll('.song-duration')[0].style.color = '#607D8B';
            });

            songElements[i].addEventListener('click', function () {
                this.querySelectorAll('.play-button-container')[0].style.display = 'none';
            });
        }

        Amplitude.init({
            continue_next: true,
            shuffle_on: false,
            preload: 'auto',
            default_album_art: 'img/default_cover_art.jpg',
            songs: songs_array,
            callbacks: {
                initialized: function () {
                    Amplitude.pause();
                    setInterval(function () {
                        Amplitude.setVolume(Amplitude.getVolume());
                    }, 500);
                    setTimeout(function () {
                        $('#' + id_container + ' #repeat').trigger('click');
                        if (current_option.waveform_width > 0) {
                            var ctx = document.createElement('canvas').getContext('2d');
                            var linGrad = ctx.createLinearGradient(0, 64, 0, 200);
                            linGrad.addColorStop(0.5, 'rgba(255,255,255,0.9)');
                            linGrad.addColorStop(0.5, 'rgba(255,255,255,0.9)');
                            wavesurfer = WaveSurfer.create({
                                container: '#waveform',
                                waveColor: linGrad,
                                progressColor: 'hsla(200,89%,46%,1)',
                                cursorColor: '#5183ce',
                                barWidth: current_option.waveform_width,
                                barRadius: 5,
                                cursorWidth: 1,
                                barGap: 1,
                                normalize: true,
                                responsive: true,
                                interact: false,
                                audioContext: Amplitude.getConfig().context
                            });
                            get_peaks(0, songs_array);
                        } else {
                            $('#' + id_container + ' #waveform').hide();
                        }
                        $('#' + id_container + ' #loading').hide();
                        $('#' + id_container + ' #blue-playlist-container').fadeIn();
                        if (mobileCheck()) $('#' + id_container + ' #control-container-mobile').hide();
                        setTimeout(function () {
                            $(document).trigger('resize');
                        }, 50);
                        $('#' + id_container + ' #waveform').css('opacity', 0);
                        $('#' + id_container + ' #amplitude-left').css('background-image', 'url(\'' + songs_array[0].cover_art_url + '\')');
                        if (songs_array[0].live) {
                            update_nowplayng(songs_array[0].url, songs_array[0].type);
                            interval_nowplayng = setInterval(function () {
                                update_nowplayng(songs_array[0].url, songs_array[0].type);
                            }, 10000);
                        }
                        Amplitude.playSongAtIndex( 0 );
                    }, 500);
                },
                song_change: function () {
                    clearInterval(interval_nowplayng);
                    var currentIndex = Amplitude.getActiveIndex();
                    $('#' + id_container + ' #amplitude-left').css('background-image', 'url(\'' + songs_array[currentIndex].cover_art_url + '\')');
                    Amplitude.setVolume(Amplitude.getVolume());
                    $('#' + id_container + ' #waveform').css('opacity', 0);
                    wavesurfer.cancelAjax();
                    if (songs_array[currentIndex].live) {
                        update_nowplayng(songs_array[currentIndex].url, songs_array[currentIndex].type);
                        interval_nowplayng = setInterval(function () {
                            update_nowplayng(songs_array[currentIndex].url, songs_array[currentIndex].type);
                        }, 10000);
                        $('#' + id_container + ' .loading_song').hide();
                    } else {
                        $('#' + id_container + ' .loading_song').show();
                    }
                    get_peaks(currentIndex, songs_array);
                },
                loadeddata: function () {

                },
                playing: function () {
                    $('#' + id_container + ' .loading_song').hide();
                    Amplitude.setVolume(Amplitude.getVolume());
                    var currentIndex = Amplitude.getActiveIndex();
                    var songs_array_len = songs_array.length;
                    if (currentIndex == (songs_array_len - 1)) {
                        var nextIndex = 0;
                    } else {
                        var nextIndex = currentIndex + 1;
                    }
                    var next_song = songs_array[nextIndex].url;
                    var preloader = new Audio();
                    preloader.src = next_song;
                    preloader.load();
                },
                timeupdate: function () {
                    var perc = Amplitude.getSongPlayedPercentage() / 100;
                    wavesurfer.seekTo(perc);
                },
                pause: function () {
                    $('#' + id_container + ' .loading_song').hide();
                },
                play: function () {
                    Amplitude.setVolume(Amplitude.getVolume());
                    $('#' + id_container + ' .loading_song').show();
                },
                stop: function () {
                    $('#' + id_container + ' .loading_song').hide();
                },
            }
        });
    }

    function get_peaks(index, songs_array) {
        wavesurfer.un('ready');
        var current_src = songs_array[index].url;
        if (songs_array[index].live == false) {
            try {
                if (current_option.waveform_width > 0) {
                    var peaks_url = current_src.substr(0, current_src.lastIndexOf(".")) + ".json";

                    $.ajax({
                        url: getpeaksTherapiesUrl,
                        type: "POST",
                        data: {
                            peaks_url: peaks_url
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        async: true,
                        success: function (rsp) {
                            if (rsp == '') {
                                wavesurfer.load(current_src);
                                wavesurfer.on('ready', function () {
                                    $('#waveform').css('opacity', 1);
                                    var peaks = wavesurfer.backend.getPeaks(1024);
                                    var peaks_json = JSON.stringify(peaks);
                                    var currentIndex = Amplitude.getActiveIndex();
                                    var current_src = songs_array[currentIndex].url;
                                    $.ajax({
                                        url: savepeaksTherapiesUrl,
                                        type: "POST",
                                        data: {
                                            current_src: current_src,
                                            peaks: peaks_json
                                        },
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        async: true,
                                        success: function (json) {
                                        }
                                    });
                                });
                            } else {
                                var peaks = rsp;
                                wavesurfer.load('/assets/empty.mp3', peaks);
                                wavesurfer.on('ready', function () {
                                    $('#waveform').css('opacity', 1);
                                });
                            }
                        },
                        error: function () {
                            wavesurfer.load(current_src);
                        }
                    });
                }
            } catch (e) {

            }
        }
    }

})(jQuery);

$(window).resize(function () {
    if (window.innerWidth <= 639) {
        if ($('#waveform').is(':visible')) {
            if ($('#control-container-mobile').is(':visible')) {
                $('div#amplitude-left').css('height', '280px');
            } else {
                $('div#amplitude-left').css('height', '250px');
            }
        } else {
            if ($('#control-container-mobile').is(':visible')) {
                $('div#amplitude-left').css('height', '250px');
            } else {
                $('div#amplitude-left').css('height', '220px');
            }
        }
    } else {
        $('div#amplitude-left').css('height', '');
    }
});

!function (e, t) {
    "object" == typeof exports && "object" == typeof module ? module.exports = t() : "function" == typeof define && define.amd ? define("Amplitude", [], t) : "object" == typeof exports ? exports.Amplitude = t() : e.Amplitude = t()
}(this, function () {
    return function (e) {
        function t(l) {
            if (a[l]) return a[l].exports;
            var u = a[l] = {i: l, l: !1, exports: {}};
            return e[l].call(u.exports, u, u.exports, t), u.l = !0, u.exports
        }

        var a = {};
        return t.m = e, t.c = a, t.i = function (e) {
            return e
        }, t.d = function (e, a, l) {
            t.o(e, a) || Object.defineProperty(e, a, {configurable: !1, enumerable: !0, get: l})
        }, t.n = function (e) {
            var a = e && e.__esModule ? function () {
                return e.default
            } : function () {
                return e
            };
            return t.d(a, "a", a), a
        }, t.o = function (e, t) {
            return Object.prototype.hasOwnProperty.call(e, t)
        }, t.p = "", t(t.s = 47)
    }([function (e, t, a) {
        "use strict";
        var l = a(59);
        e.exports = {
            version: l.version,
            audio: new Audio,
            active_metadata: {},
            active_album: "",
            active_index: 0,
            active_playlist: null,
            playback_speed: 1,
            callbacks: {},
            songs: [],
            playlists: {},
            start_song: "",
            starting_playlist: "",
            starting_playlist_song: "",
            repeat: !1,
            repeat_song: !1,
            shuffle_list: {},
            shuffle_on: !1,
            default_album_art: "",
            default_playlist_art: "",
            debug: !1,
            volume: .5,
            pre_mute_volume: .5,
            volume_increment: 5,
            volume_decrement: 5,
            soundcloud_client: "",
            soundcloud_use_art: !1,
            soundcloud_song_count: 0,
            soundcloud_songs_ready: 0,
            is_touch_moving: !1,
            buffered: 0,
            bindings: {},
            continue_next: !0,
            delay: 0,
            player_state: "stopped",
            web_audio_api_available: !1,
            context: null,
            source: null,
            analyser: null,
            visualizations: {available: [], active: [], backup: ""},
            waveforms: {sample_rate: 100, built: []}
        }
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(5), d = (l(i), a(3)), s = (l(d), a(2)), o = (l(s), a(7)), f = (l(o), a(9)),
            r = l(f), c = a(4), p = l(c), v = a(16), y = l(v), g = a(6), m = l(g), _ = function () {
                function e() {
                    y.default.stop(), y.default.run(), n.default.active_metadata.live && s(), /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && !n.default.paused && s();
                    var e = n.default.audio.play();
                    void 0 !== e && e.then(function (e) {
                    }).catch(function (e) {
                    }), n.default.audio.play(), n.default.audio.playbackRate = n.default.playback_speed, m.default.setPlayerState()
                }

                function t() {
                    y.default.stop(), n.default.audio.pause(), n.default.paused = !0, n.default.active_metadata.live && d(), m.default.setPlayerState()
                }

                function a() {
                    y.default.stop(), 0 != n.default.audio.currentTime && (n.default.audio.currentTime = 0), n.default.audio.pause(), n.default.active_metadata.live && d(), m.default.setPlayerState(), r.default.run("stop")
                }

                function l(e) {
                    n.default.audio.muted = 0 == e, n.default.volume = e, n.default.audio.volume = e / 100
                }

                function u(e) {
                    n.default.active_metadata.live || (n.default.audio.currentTime = n.default.audio.duration * (e / 100))
                }

                function i(e) {
                    n.default.audio.addEventListener("canplaythrough", function () {
                        n.default.audio.duration >= e && e > 0 ? n.default.audio.currentTime = e : p.default.writeMessage("Amplitude can't skip to a location greater than the duration of the audio or less than 0")
                    }, {once: !0})
                }

                function d() {
                    n.default.audio.src = "", n.default.audio.load()
                }

                function s() {
                    n.default.audio.src = n.default.active_metadata.url, n.default.audio.load()
                }

                function o(e) {
                    n.default.playback_speed = e, n.default.audio.playbackRate = n.default.playback_speed
                }

                return {
                    play: e,
                    pause: t,
                    stop: a,
                    setVolume: l,
                    setSongLocation: u,
                    skipToLocation: i,
                    disconnectStream: d,
                    reconnectStream: s,
                    setPlaybackSpeed: o
                }
            }();
        t.default = _, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e() {
                t(), a(), l(), n()
            }

            function t() {
                for (var e = u.default.audio.paused ? "paused" : "playing", t = document.querySelectorAll(".amplitude-play-pause"), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist"),
                        n = t[a].getAttribute("data-amplitude-song-index");
                    if (null == l && null == n) switch (e) {
                        case"playing":
                            d(t[a]);
                            break;
                        case"paused":
                            s(t[a])
                    }
                }
            }

            function a() {
                for (var e = u.default.audio.paused ? "paused" : "playing", t = document.querySelectorAll('.amplitude-play-pause[data-amplitude-playlist="' + u.default.active_playlist + '"]'), a = 0; a < t.length; a++) {
                    if (null == t[a].getAttribute("data-amplitude-song-index")) switch (e) {
                        case"playing":
                            d(t[a]);
                            break;
                        case"paused":
                            s(t[a])
                    }
                }
            }

            function l() {
                for (var e = u.default.audio.paused ? "paused" : "playing", t = document.querySelectorAll('.amplitude-play-pause[data-amplitude-song-index="' + u.default.active_index + '"]'), a = 0; a < t.length; a++) {
                    if (null == t[a].getAttribute("data-amplitude-playlist")) switch (e) {
                        case"playing":
                            d(t[a]);
                            break;
                        case"paused":
                            s(t[a])
                    }
                }
            }

            function n() {
                for (var e = u.default.audio.paused ? "paused" : "playing", t = "" != u.default.active_playlist && null != u.default.active_playlist ? u.default.playlists[u.default.active_playlist].active_index : null, a = document.querySelectorAll('.amplitude-play-pause[data-amplitude-song-index="' + t + '"][data-amplitude-playlist="' + u.default.active_playlist + '"]'), l = 0; l < a.length; l++) switch (e) {
                    case"playing":
                        d(a[l]);
                        break;
                    case"paused":
                        s(a[l])
                }
            }

            function i() {
                for (var e = document.querySelectorAll(".amplitude-play-pause"), t = 0; t < e.length; t++) s(e[t])
            }

            function d(e) {
                e.classList.add("amplitude-playing"), e.classList.remove("amplitude-paused")
            }

            function s(e) {
                e.classList.remove("amplitude-playing"), e.classList.add("amplitude-paused")
            }

            return {sync: e, syncGlobal: t, syncPlaylist: a, syncSong: l, syncSongInPlaylist: n, syncToPause: i}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(1), d = l(i), s = a(9), o = l(s), f = a(5), r = l(f), c = a(2), p = l(c),
            v = a(14), y = l(v), g = a(20), m = l(g), _ = a(15), h = l(_), b = a(7), A = l(b), x = a(49), M = l(x),
            P = function () {
                function e() {
                    var e = arguments.length > 0 && void 0 !== arguments[0] && arguments[0], t = null, a = {}, l = !1;
                    n.default.repeat_song ? n.default.shuffle_on ? (t = n.default.shuffle_list[n.default.active_index].index, a = n.default.shuffle_list[t]) : (t = n.default.active_index, a = n.default.songs[t]) : n.default.shuffle_on ? (parseInt(n.default.active_index) + 1 < n.default.shuffle_list.length ? t = parseInt(n.default.active_index) + 1 : (t = 0, l = !0), a = n.default.shuffle_list[t]) : (parseInt(n.default.active_index) + 1 < n.default.songs.length ? t = parseInt(n.default.active_index) + 1 : (t = 0, l = !0), a = n.default.songs[t]), u(a, t), l && !n.default.repeat || e && !n.default.repeat && l || d.default.play(), p.default.sync(), o.default.run("next"), n.default.repeat_song && o.default.run("song_repeated")
                }

                function t(e) {
                    var t = arguments.length > 1 && void 0 !== arguments[1] && arguments[1], a = null, l = {}, u = !1;
                    n.default.repeat_song ? n.default.playlists[e].shuffle ? (a = n.default.playlists[e].active_index, l = n.default.playlists[e].shuffle_list[a]) : (a = n.default.playlists[e].active_index, l = n.default.playlists[e].songs[a]) : n.default.playlists[e].shuffle ? (parseInt(n.default.playlists[e].active_index) + 1 < n.default.playlists[e].shuffle_list.length ? a = n.default.playlists[e].active_index + 1 : (a = 0, u = !0), l = n.default.playlists[e].shuffle_list[a]) : (parseInt(n.default.playlists[e].active_index) + 1 < n.default.playlists[e].songs.length ? a = parseInt(n.default.playlists[e].active_index) + 1 : (a = 0, u = !0), l = n.default.playlists[e].songs[a]), c(e), i(e, l, a), u && !n.default.repeat || t && !n.default.repeat && u || d.default.play(), p.default.sync(), o.default.run("next"), n.default.repeat_song && o.default.run("song_repeated")
                }

                function a() {
                    var e = null, t = {};
                    n.default.repeat_song ? n.default.shuffle_on ? (e = n.default.active_index, t = n.default.shuffle_list[e]) : (e = n.default.active_index, t = n.default.songs[e]) : (e = parseInt(n.default.active_index) - 1 >= 0 ? parseInt(n.default.active_index - 1) : parseInt(n.default.songs.length - 1), t = n.default.shuffle_on ? n.default.shuffle_list[e] : n.default.songs[e]), u(t, e), d.default.play(), p.default.sync(), o.default.run("prev"), n.default.repeat_song && o.default.run("song_repeated")
                }

                function l(e) {
                    var t = null, a = {};
                    n.default.repeat_song ? n.default.playlists[e].shuffle ? (t = n.default.playlists[e].active_index, a = n.default.playlists[e].shuffle_list[t]) : (t = n.default.playlists[e].active_index, a = n.default.playlists[e].songs[t]) : (t = parseInt(n.default.playlists[e].active_index) - 1 >= 0 ? parseInt(n.default.playlists[e].active_index - 1) : parseInt(n.default.playlists[e].songs.length - 1), a = n.default.playlists[e].shuffle ? n.default.playlists[e].shuffle_list[t] : n.default.playlists[e].songs[t]), c(e), i(e, a, t), d.default.play(), p.default.sync(), o.default.run("prev"), n.default.repeat_song && o.default.run("song_repeated")
                }

                function u(e, t) {
                    var a = arguments.length > 2 && void 0 !== arguments[2] && arguments[2];
                    s(e), n.default.audio.src = e.url, n.default.active_metadata = e, n.default.active_album = e.album, n.default.active_index = parseInt(t), f(a)
                }

                function i(e, t, a) {
                    var l = arguments.length > 3 && void 0 !== arguments[3] && arguments[3];
                    s(t), n.default.audio.src = t.url, n.default.active_metadata = t, n.default.active_album = t.album, n.default.active_index = null, n.default.playlists[e].active_index = parseInt(a), f(l)
                }

                function s(e) {
                    d.default.stop(), p.default.syncToPause(), y.default.resetElements(), m.default.resetElements(), h.default.resetCurrentTimes(), r.default.newAlbum(e) && o.default.run("album_change")
                }

                function f(e) {
                    A.default.displayMetaData(), M.default.setActive(e), h.default.resetDurationTimes(), o.default.run("song_change")
                }

                function c(e) {
                    n.default.active_playlist != e && (o.default.run("playlist_changed"), n.default.active_playlist = e, null != e && (n.default.playlists[e].active_index = 0))
                }

                return {
                    setNext: e,
                    setNextPlaylist: t,
                    setPrevious: a,
                    setPreviousPlaylist: l,
                    changeSong: u,
                    changeSongPlaylist: i,
                    setActivePlaylist: c
                }
            }();
        t.default = P, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e(e) {
                u.default.debug && console.log(e)
            }

            return {writeMessage: e}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e(e, t) {
                return u.default.active_playlist != e || (null == u.default.active_playlist && null == e ? u.default.active_index != t : u.default.active_playlist == e && u.default.playlists[e].active_index != t)
            }

            function t(e) {
                return u.default.active_album != e
            }

            function a(e) {
                return u.default.active_playlist != e
            }

            function l(e) {
                return /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test(e)
            }

            function n(e) {
                return !isNaN(e) && parseInt(Number(e)) == e && !isNaN(parseInt(e, 10))
            }

            return {newSong: e, newAlbum: t, newPlaylist: a, isURL: l, isInt: n}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e() {
                u.default.audio = new Audio, u.default.active_metadata = {}, u.default.active_album = "", u.default.active_index = 0, u.default.active_playlist = null, u.default.playback_speed = 1, u.default.callbacks = {}, u.default.songs = [], u.default.playlists = {}, u.default.start_song = "", u.default.starting_playlist = "", u.default.starting_playlist_song = "", u.default.repeat = !1, u.default.shuffle_list = {}, u.default.shuffle_on = !1, u.default.default_album_art = "", u.default.default_playlist_art = "", u.default.debug = !1, u.default.volume = .5, u.default.pre_mute_volume = .5, u.default.volume_increment = 5, u.default.volume_decrement = 5, u.default.soundcloud_client = "", u.default.soundcloud_use_art = !1, u.default.soundcloud_song_count = 0, u.default.soundcloud_songs_ready = 0, u.default.continue_next = !0
            }

            function t() {
                u.default.audio.paused && 0 == u.default.audio.currentTime && (u.default.player_state = "stopped"), u.default.audio.paused && u.default.audio.currentTime > 0 && (u.default.player_state = "paused"), u.default.audio.paused || (u.default.player_state = "playing")
            }

            return {resetConfig: e, setPlayerState: t}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e() {
                for (var e = ["cover_art_url", "station_art_url", "podcast_episode_cover_art_url"], t = document.querySelectorAll("[data-amplitude-song-info]"), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-song-info"),
                        n = t[a].getAttribute("data-amplitude-playlist"),
                        i = t[a].getAttribute("data-amplitude-song-index");
                    if (null == i && (u.default.active_playlist == n || null == n && null == i)) {
                        var d = void 0 != u.default.active_metadata[l] ? u.default.active_metadata[l] : null;
                        e.indexOf(l) >= 0 ? (d = d || u.default.default_album_art, t[a].setAttribute("src", d)) : (d = d || "", t[a].innerHTML = d)
                    }
                }
            }

            function t() {
                for (var e = ["image_url"], t = document.querySelectorAll("[data-amplitude-playlist-info]"), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist-info"),
                        n = t[a].getAttribute("data-amplitude-playlist");
                    void 0 != u.default.playlists[n][l] ? e.indexOf(l) >= 0 ? t[a].setAttribute("src", u.default.playlists[n][l]) : t[a].innerHTML = u.default.playlists[n][l] : e.indexOf(l) >= 0 ? "" != u.default.default_playlist_art ? t[a].setAttribute("src", u.default.default_playlist_art) : t[a].setAttribute("src", "") : t[a].innerHTML = ""
                }
            }

            function a(e, t) {
                for (var a = ["cover_art_url", "station_art_url", "podcast_episode_cover_art_url"], l = document.querySelectorAll('[data-amplitude-song-info][data-amplitude-playlist="' + t + '"]'), u = 0; u < l.length; u++) {
                    var n = l[u].getAttribute("data-amplitude-song-info");
                    l[u].getAttribute("data-amplitude-playlist") == t && (void 0 != e[n] ? a.indexOf(n) >= 0 ? l[u].setAttribute("src", e[n]) : l[u].innerHTML = e[n] : a.indexOf(n) >= 0 ? "" != e.default_album_art ? l[u].setAttribute("src", e.default_album_art) : l[u].setAttribute("src", "") : l[u].innerHTML = "")
                }
            }

            function l() {
                for (var e = ["cover_art_url", "station_art_url", "podcast_episode_cover_art_url"], a = document.querySelectorAll("[data-amplitude-song-info]"), l = 0; l < a.length; l++) {
                    var n = a[l].getAttribute("data-amplitude-song-index"),
                        i = a[l].getAttribute("data-amplitude-playlist");
                    if (null != n && null == i) {
                        var d = a[l].getAttribute("data-amplitude-song-info"),
                            s = void 0 != u.default.songs[n][d] ? u.default.songs[n][d] : null;
                        e.indexOf(d) >= 0 ? (s = s || u.default.default_album_art, a[l].setAttribute("src", s)) : a[l].innerHTML = s
                    }
                    if (null != n && null != i) {
                        var o = a[l].getAttribute("data-amplitude-song-info");
                        void 0 != u.default.playlists[i].songs[n][o] && (e.indexOf(o) >= 0 ? a[l].setAttribute("src", u.default.playlists[i].songs[n][o]) : a[l].innerHTML = u.default.playlists[i].songs[n][o])
                    }
                }
                t()
            }

            return {displayMetaData: e, setFirstSongInPlaylist: a, syncMetaData: l, displayPlaylistMetaData: t}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e() {
                for (var e = document.getElementsByClassName("amplitude-repeat"), t = 0; t < e.length; t++) u.default.repeat ? (e[t].classList.add("amplitude-repeat-on"), e[t].classList.remove("amplitude-repeat-off")) : (e[t].classList.remove("amplitude-repeat-on"), e[t].classList.add("amplitude-repeat-off"))
            }

            function t(e) {
                for (var t = document.getElementsByClassName("amplitude-repeat"), a = 0; a < t.length; a++) t[a].getAttribute("data-amplitude-playlist") == e && (u.default.playlists[e].repeat ? (t[a].classList.add("amplitude-repeat-on"), t[a].classList.remove("amplitude-repeat-off")) : (t[a].classList.add("amplitude-repeat-off"), t[a].classList.remove("amplitude-repeat-on")))
            }

            function a() {
                for (var e = document.getElementsByClassName("amplitude-repeat-song"), t = 0; t < e.length; t++) u.default.repeat_song ? (e[t].classList.add("amplitude-repeat-song-on"), e[t].classList.remove("amplitude-repeat-song-off")) : (e[t].classList.remove("amplitude-repeat-song-on"), e[t].classList.add("amplitude-repeat-song-off"))
            }

            return {syncRepeat: e, syncRepeatPlaylist: t, syncRepeatSong: a}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(4), d = l(i), s = function () {
            function e() {
                n.default.audio.addEventListener("abort", function () {
                    t("abort")
                }), n.default.audio.addEventListener("error", function () {
                    t("error")
                }), n.default.audio.addEventListener("loadeddata", function () {
                    t("loadeddata")
                }), n.default.audio.addEventListener("loadedmetadata", function () {
                    t("loadedmetadata")
                }), n.default.audio.addEventListener("loadstart", function () {
                    t("loadstart")
                }), n.default.audio.addEventListener("pause", function () {
                    t("pause")
                }), n.default.audio.addEventListener("playing", function () {
                    t("playing")
                }), n.default.audio.addEventListener("play", function () {
                    t("play")
                }), n.default.audio.addEventListener("progress", function () {
                    t("progress")
                }), n.default.audio.addEventListener("ratechange", function () {
                    t("ratechange")
                }), n.default.audio.addEventListener("seeked", function () {
                    t("seeked")
                }), n.default.audio.addEventListener("seeking", function () {
                    t("seeking")
                }), n.default.audio.addEventListener("stalled", function () {
                    t("stalled")
                }), n.default.audio.addEventListener("suspend", function () {
                    t("suspend")
                }), n.default.audio.addEventListener("timeupdate", function () {
                    t("timeupdate")
                }), n.default.audio.addEventListener("volumechange", function () {
                    t("volumechange")
                }), n.default.audio.addEventListener("waiting", function () {
                    t("waiting")
                }), n.default.audio.addEventListener("canplay", function () {
                    t("canplay")
                }), n.default.audio.addEventListener("canplaythrough", function () {
                    t("canplaythrough")
                }), n.default.audio.addEventListener("durationchange", function () {
                    t("durationchange")
                }), n.default.audio.addEventListener("ended", function () {
                    t("ended")
                })
            }

            function t(e) {
                if (n.default.callbacks[e]) {
                    var t = n.default.callbacks[e];
                    d.default.writeMessage("Running Callback: " + e);
                    try {
                        t()
                    } catch (e) {
                        if ("CANCEL EVENT" == e.message) throw e;
                        d.default.writeMessage("Callback error: " + e.message)
                    }
                }
            }

            return {initialize: e, run: t}
        }();
        t.default = s, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = function () {
            function e(e) {
                for (var t = document.getElementsByClassName("amplitude-mute"), a = 0; a < t.length; a++) e ? (t[a].classList.remove("amplitude-not-muted"), t[a].classList.add("amplitude-muted")) : (t[a].classList.add("amplitude-not-muted"), t[a].classList.remove("amplitude-muted"))
            }

            return {setMuted: e}
        }();
        t.default = l, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e() {
                for (var e = document.getElementsByClassName("amplitude-volume-slider"), t = 0; t < e.length; t++) e[t].value = 100 * u.default.audio.volume
            }

            return {sync: e}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e(e) {
                u.default.repeat = e
            }

            function t(e, t) {
                u.default.playlists[t].repeat = e
            }

            function a(e) {
                u.default.repeat_song = e
            }

            return {setRepeat: e, setRepeatPlaylist: t, setRepeatSong: a}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e(e) {
                u.default.shuffle_on = e, e ? n() : u.default.shuffle_list = []
            }

            function t() {
                u.default.shuffle_on ? (u.default.shuffle_on = !1, u.default.shuffle_list = []) : (u.default.shuffle_on = !0, n())
            }

            function a(e, t) {
                u.default.playlists[e].shuffle = t, u.default.playlists[e].shuffle ? i(e) : u.default.playlists[e].shuffle_list = []
            }

            function l(e) {
                u.default.playlists[e].shuffle ? (u.default.playlists[e].shuffle = !1, u.default.playlists[e].shuffle_list = []) : (u.default.playlists[e].shuffle = !0, i(e))
            }

            function n() {
                for (var e = new Array(u.default.songs.length), t = 0; t < u.default.songs.length; t++) e[t] = u.default.songs[t];
                for (var a = u.default.songs.length - 1; a > 0; a--) {
                    d(e, a, Math.floor(Math.random() * u.default.songs.length + 1) - 1)
                }
                u.default.shuffle_list = e
            }

            function i(e) {
                for (var t = new Array(u.default.playlists[e].songs.length), a = 0; a < u.default.playlists[e].songs.length; a++) t[a] = u.default.playlists[e].songs[a];
                for (var l = u.default.playlists[e].songs.length - 1; l > 0; l--) {
                    d(t, l, Math.floor(Math.random() * u.default.playlists[e].songs.length + 1) - 1)
                }
                u.default.playlists[e].shuffle_list = t
            }

            function d(e, t, a) {
                var l = e[t];
                e[t] = e[a], e[a] = l
            }

            return {
                setShuffle: e,
                toggleShuffle: t,
                setShufflePlaylist: a,
                toggleShufflePlaylist: l,
                shuffleSongs: n,
                shufflePlaylistSongs: i
            }
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e(e, u, i) {
                t(e), a(e, u), l(e, i), n(e, u)
            }

            function t(e) {
                e = isNaN(e) ? 0 : e;
                for (var t = document.querySelectorAll(".amplitude-song-slider"), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist"),
                        u = t[a].getAttribute("data-amplitude-song-index");
                    null == l && null == u && (t[a].value = e)
                }
            }

            function a(e, t) {
                e = isNaN(e) ? 0 : e;
                for (var a = document.querySelectorAll('.amplitude-song-slider[data-amplitude-playlist="' + t + '"]'), l = 0; l < a.length; l++) {
                    var u = a[l].getAttribute("data-amplitude-playlist"),
                        n = a[l].getAttribute("data-amplitude-song-index");
                    u == t && null == n && (a[l].value = e)
                }
            }

            function l(e, t) {
                if (null == u.default.active_playlist) {
                    e = isNaN(e) ? 0 : e;
                    for (var a = document.querySelectorAll('.amplitude-song-slider[data-amplitude-song-index="' + t + '"]'), l = 0; l < a.length; l++) {
                        var n = a[l].getAttribute("data-amplitude-playlist"),
                            i = a[l].getAttribute("data-amplitude-song-index");
                        null == n && i == t && (a[l].value = e)
                    }
                }
            }

            function n(e, t) {
                e = isNaN(e) ? 0 : e;
                for (var a = "" != u.default.active_playlist && null != u.default.active_playlist ? u.default.playlists[u.default.active_playlist].active_index : null, l = document.querySelectorAll('.amplitude-song-slider[data-amplitude-playlist="' + t + '"][data-amplitude-song-index="' + a + '"]'), n = 0; n < l.length; n++) l[n].value = e
            }

            function i() {
                for (var e = document.getElementsByClassName("amplitude-song-slider"), t = 0; t < e.length; t++) e[t].value = 0
            }

            return {sync: e, syncMain: t, syncPlaylist: a, syncSong: l, syncSongInPlaylist: n, resetElements: i}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(53), n = l(u), i = a(50), d = l(i), s = a(51), o = l(s), f = a(52), r = l(f), c = a(54), p = l(c),
            v = a(55), y = l(v), g = a(56), m = l(g), _ = a(57), h = l(_), b = a(58), A = l(b), x = function () {
                function e() {
                    n.default.resetTimes(), d.default.resetTimes(), o.default.resetTimes(), r.default.resetTimes()
                }

                function t(e) {
                    n.default.sync(e), d.default.sync(e.hours), o.default.sync(e.minutes), r.default.sync(e.seconds)
                }

                function a() {
                    p.default.resetTimes(), y.default.resetTimes(), m.default.resetTimes(), h.default.resetTimes(), A.default.resetTimes()
                }

                function l(e, t) {
                    p.default.sync(e, t), A.default.sync(t), y.default.sync(t.hours), m.default.sync(t.minutes), h.default.sync(t.seconds)
                }

                return {resetCurrentTimes: e, syncCurrentTimes: t, resetDurationTimes: a, syncDurationTimes: l}
            }();
        t.default = x, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(4), d = (l(i), function () {
            function e() {
                var e = document.querySelectorAll(".amplitude-visualization");
                if (n.default.web_audio_api_available) {
                    if (Object.keys(n.default.visualizations.available).length > 0 && e.length > 0) for (var i = 0; i < e.length; i++) {
                        var d = e[i].getAttribute("data-amplitude-playlist"),
                            s = e[i].getAttribute("data-amplitude-song-index");
                        null == d && null == s && t(e[i]), null != d && null == s && a(e[i], d), null == d && null != s && l(e[i], s), null != d && null != s && u(e[i], d, s)
                    }
                } else o()
            }

            function t(e) {
                var t = n.default.visualization,
                    a = null != n.default.active_index ? n.default.songs[n.default.active_index].visualization : n.default.playlists[n.default.active_playlist].songs[n.default.playlists[n.default.active_playlist].active_index].visualization;
                if (void 0 != a && void 0 != n.default.visualizations.available[a]) i(a, e); else if (void 0 != t && void 0 != n.default.visualizations.available[t]) i(t, e); else {
                    var l = Object.keys(n.default.visualizations.available).length > 0 ? Object.keys(n.default.visualizations.available)[0] : null;
                    null != l && i(l, e)
                }
            }

            function a(e, t) {
                if (t == n.default.active_playlist) {
                    var a = n.default.playlists[n.default.active_playlist].songs[n.default.playlists[n.default.active_playlist].active_index].visualization,
                        l = n.default.playlists[n.default.active_playlist].visualization, u = n.default.visualization;
                    if (void 0 != a && void 0 != n.default.visualizations.available[a]) i(a, e); else if (void 0 != l && void 0 != n.default.visualizations.available[l]) i(l, e); else if (void 0 != u && void 0 != n.default.visualizations.available[u]) i(u, e); else {
                        var d = Object.keys(n.default.visualizations.available).length > 0 ? Object.keys(n.default.visualizations.available)[0] : null;
                        null != d && i(d, e)
                    }
                }
            }

            function l(e, t) {
                if (t == n.default.active_index) {
                    var a = n.default.songs[n.default.active_index].visualization, l = n.default.visualization;
                    if (void 0 != a && void 0 != n.default.visualizations.available[a]) i(a, e); else if (void 0 != l && void 0 != n.default.visualizations.available[l]) i(l, e); else {
                        var u = Object.keys(n.default.visualizations.available).length > 0 ? Object.keys(n.default.visualizations.available)[0] : null;
                        null != u && i(u, e)
                    }
                }
            }

            function u(e, t, a) {
                if (t == n.default.active_playlist && n.default.playlists[t].active_index == a) {
                    var l = n.default.playlists[n.default.active_playlist].songs[n.default.playlists[n.default.active_playlist].active_index].visualization,
                        u = n.default.playlists[n.default.active_playlist].visualization, d = n.default.visualization;
                    if (void 0 != l && void 0 != n.default.visualizations.available[l]) i(l, e); else if (void 0 != u && void 0 != n.default.visualizations.available[u]) i(u, e); else if (void 0 != d && void 0 != n.default.visualizations.available[d]) i(d, e); else {
                        var s = Object.keys(n.default.visualizations.available).length > 0 ? Object.keys(n.default.visualizations.available)[0] : null;
                        null != s && i(s, e)
                    }
                }
            }

            function i(e, t) {
                var a = new n.default.visualizations.available[e].object;
                a.setPreferences(n.default.visualizations.available[e].preferences), a.startVisualization(t), n.default.visualizations.active.push(a)
            }

            function d() {
                for (var e = 0; e < n.default.visualizations.active.length; e++) n.default.visualizations.active[e].stopVisualization();
                n.default.visualizations.active = []
            }

            function s(e, t) {
                var a = new e;
                n.default.visualizations.available[a.getID()] = new Array, n.default.visualizations.available[a.getID()].object = e, n.default.visualizations.available[a.getID()].preferences = t
            }

            function o() {
                var e = document.querySelectorAll(".amplitude-visualization");
                if (e.length > 0) for (var t = 0; t < e.length; t++) {
                    var a = e[t].getAttribute("data-amplitude-playlist"),
                        l = e[t].getAttribute("data-amplitude-song-index");
                    null == a && null == l && f(e[t]), null != a && null == l && r(e[t], a), null == a && null != l && c(e[t], l), null != a && null != l && p(e[t], a, l)
                }
            }

            function f(e) {
                e.style.backgroundImage = "url(" + n.default.active_metadata.cover_art_url + ")"
            }

            function r(e, t) {
                n.default.active_playlist == t && (e.style.backgroundImage = "url(" + n.default.active_metadata.cover_art_url + ")")
            }

            function c(e, t) {
                n.default.active_index == t && (e.style.backgroundImage = "url(" + n.default.active_metadata.cover_art_url + ")")
            }

            function p(e, t, a) {
                n.default.active_playlist == t && n.default.playlists[active_playlist].active_index == a && (e.style.backgroundImage = "url(" + n.default.active_metadata.cover_art_url + ")")
            }

            return {run: e, stop: d, register: s}
        }());
        t.default = d, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(21), d = l(i), s = function () {
            function e(e) {
                s = e;
                var a = document.getElementsByTagName("head")[0], l = document.createElement("script");
                l.type = "text/javascript", l.src = "https://connect.soundcloud.com/sdk.js", l.onreadystatechange = t, l.onload = t, a.appendChild(l)
            }

            function t() {
                SC.initialize({client_id: n.default.soundcloud_client}), a()
            }

            function a() {
                for (var e = /^https?:\/\/(soundcloud.com|snd.sc)\/(.*)$/, t = 0; t < n.default.songs.length; t++) n.default.songs[t].url.match(e) && (n.default.soundcloud_song_count++, u(n.default.songs[t].url, t))
            }

            function l(e, t, a) {
                var l = arguments.length > 3 && void 0 !== arguments[3] && arguments[3];
                SC.get("/resolve/?url=" + e, function (e) {
                    e.streamable ? null != t ? (n.default.playlists[t].songs[a].url = e.stream_url + "?client_id=" + n.default.soundcloud_client, l && (n.default.playlists[t].shuffle_list[a].url = e.stream_url + "?client_id=" + n.default.soundcloud_client), n.default.soundcloud_use_art && (n.default.playlists[t].songs[a].cover_art_url = e.artwork_url, l && (n.default.playlists[t].shuffle_list[a].cover_art_url = e.artwork_url)), n.default.playlists[t].songs[a].soundcloud_data = e, l && (n.default.playlists[t].shuffle_list[a].soundcloud_data = e)) : (n.default.songs[a].url = e.stream_url + "?client_id=" + n.default.soundcloud_client, l && (n.default.shuffle_list[a].stream_url, n.default.soundcloud_client), n.default.soundcloud_use_art && (n.default.songs[a].cover_art_url = e.artwork_url, l && (n.default.shuffle_list[a].cover_art_url = e.artwork_url)), n.default.songs[a].soundcloud_data = e, l && (n.default.shuffle_list[a].soundcloud_data = e)) : null != t ? AmplitudeHelpers.writeDebugMessage(n.default.playlists[t].songs[a].name + " by " + n.default.playlists[t].songs[a].artist + " is not streamable by the Soundcloud API") : AmplitudeHelpers.writeDebugMessage(n.default.songs[a].name + " by " + n.default.songs[a].artist + " is not streamable by the Soundcloud API")
                })
            }

            function u(e, t) {
                SC.get("/resolve/?url=" + e, function (e) {
                    e.streamable ? (n.default.songs[t].url = e.stream_url + "?client_id=" + n.default.soundcloud_client, n.default.soundcloud_use_art && (n.default.songs[t].cover_art_url = e.artwork_url), n.default.songs[t].soundcloud_data = e) : AmplitudeHelpers.writeDebugMessage(n.default.songs[t].name + " by " + n.default.songs[t].artist + " is not streamable by the Soundcloud API"), ++n.default.soundcloud_songs_ready == n.default.soundcloud_song_count && d.default.setConfig(s)
                })
            }

            function i(e) {
                var t = /^https?:\/\/(soundcloud.com|snd.sc)\/(.*)$/;
                return e.match(t)
            }

            var s = {};
            return {loadSoundCloud: e, resolveIndividualStreamableURL: l, isSoundCloudURL: i}
        }();
        t.default = s, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e() {
                for (var e = document.getElementsByClassName("amplitude-playback-speed"), t = 0; t < e.length; t++) switch (e[t].classList.remove("amplitude-playback-speed-10"), e[t].classList.remove("amplitude-playback-speed-15"), e[t].classList.remove("amplitude-playback-speed-20"), u.default.playback_speed) {
                    case 1:
                        e[t].classList.add("amplitude-playback-speed-10");
                        break;
                    case 1.5:
                        e[t].classList.add("amplitude-playback-speed-15");
                        break;
                    case 2:
                        e[t].classList.add("amplitude-playback-speed-20")
                }
            }

            return {sync: e}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e() {
                for (var e = document.getElementsByClassName("amplitude-shuffle"), t = 0; t < e.length; t++) null == e[t].getAttribute("data-amplitude-playlist") && (u.default.shuffle_on ? (e[t].classList.add("amplitude-shuffle-on"), e[t].classList.remove("amplitude-shuffle-off")) : (e[t].classList.add("amplitude-shuffle-off"), e[t].classList.remove("amplitude-shuffle-on")))
            }

            function t(e) {
                for (var t = document.querySelectorAll('.amplitude-shuffle[data-amplitude-playlist="' + e + '"]'), a = 0; a < t.length; a++) u.default.playlists[e].shuffle ? (t[a].classList.add("amplitude-shuffle-on"), t[a].classList.remove("amplitude-shuffle-off")) : (t[a].classList.add("amplitude-shuffle-off"), t[a].classList.remove("amplitude-shuffle-on"))
            }

            return {syncMain: e, syncPlaylist: t}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e(e) {
                t(e), a(e), l(e), n(e)
            }

            function t(e) {
                if (!isNaN(e)) for (var t = document.querySelectorAll(".amplitude-song-played-progress"), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist"),
                        u = t[a].getAttribute("data-amplitude-song-index");
                    if (null == l && null == u) {
                        var n = t[a].max;
                        t[a].value = e / 100 * n
                    }
                }
            }

            function a(e) {
                if (!isNaN(e)) for (var t = document.querySelectorAll('.amplitude-song-played-progress[data-amplitude-playlist="' + u.default.active_playlist + '"]'), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-song-index");
                    if (null == l) {
                        var n = t[a].max;
                        t[a].value = e / 100 * n
                    }
                }
            }

            function l(e) {
                if (null == u.default.active_playlist && !isNaN(e)) for (var t = document.querySelectorAll('.amplitude-song-played-progress[data-amplitude-song-index="' + u.default.active_index + '"]'), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist");
                    if (null == l) {
                        var n = t[a].max;
                        t[a].value = e / 100 * n
                    }
                }
            }

            function n(e) {
                if (!isNaN(e)) for (var t = "" != u.default.active_playlist && null != u.default.active_playlist ? u.default.playlists[u.default.active_playlist].active_index : null, a = document.querySelectorAll('.amplitude-song-played-progress[data-amplitude-playlist="' + u.default.active_playlist + '"][data-amplitude-song-index="' + t + '"]'), l = 0; l < a.length; l++) {
                    var n = a[l].getAttribute("data-amplitude-playlist"),
                        i = a[l].getAttribute("data-amplitude-song-index");
                    if (null != n && null != i) {
                        var d = a[l].max;
                        a[l].value = e / 100 * d
                    }
                }
            }

            function i() {
                for (var e = document.getElementsByClassName("amplitude-song-played-progress"), t = 0; t < e.length; t++) e[t].value = 0
            }

            return {sync: e, resetElements: i}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
                return typeof e
            } : function (e) {
                return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
            }, n = a(0), i = l(n), d = a(1), s = l(d), o = a(17), f = l(o), r = a(6), c = l(r), p = a(4), v = l(p),
            y = a(5), g = l(y), m = a(13), _ = l(m), h = a(26), b = l(h), A = a(46), x = l(A), M = a(16), P = l(M),
            S = a(22), L = l(S), w = a(3), E = l(w), k = a(9), T = l(k), O = a(48), C = l(O), N = a(19), j = l(N),
            I = a(10), q = l(I), z = a(11), H = l(z), B = a(15), D = l(B), R = a(2), V = l(R), U = a(7), F = l(U),
            W = a(18), G = l(W), Y = a(8), X = l(Y), J = function () {
                function e(e) {
                    var t = !1;
                    if (c.default.resetConfig(), b.default.initialize(), T.default.initialize(), i.default.debug = void 0 != e.debug && e.debug, l(e), e.songs ? 0 != e.songs.length ? (i.default.songs = e.songs, t = !0) : v.default.writeMessage("Please add some songs, to your songs object!") : v.default.writeMessage("Please provide a songs object for AmplitudeJS to run!"), x.default.webAudioAPIAvailable()) {
                        if (x.default.determineUsingAnyFX() && (x.default.configureWebAudioAPI(), document.documentElement.addEventListener("mousedown", function () {
                            "running" !== i.default.context.state && i.default.context.resume()
                        }), document.documentElement.addEventListener("keydown", function () {
                            "running" !== i.default.context.state && i.default.context.resume()
                        }), document.documentElement.addEventListener("keyup", function () {
                            "running" !== i.default.context.state && i.default.context.resume()
                        }), void 0 != e.waveforms && void 0 != e.waveforms.sample_rate && (i.default.waveforms.sample_rate = e.waveforms.sample_rate), L.default.init(), void 0 != e.visualizations && e.visualizations.length > 0)) for (var u = 0; u < e.visualizations.length; u++) P.default.register(e.visualizations[u].object, e.visualizations[u].params)
                    } else v.default.writeMessage("The Web Audio API is not available on this platform. We are using your defined backups!");
                    if (o(), r(), t) {
                        i.default.soundcloud_client = void 0 != e.soundcloud_client ? e.soundcloud_client : "", i.default.soundcloud_use_art = void 0 != e.soundcloud_use_art ? e.soundcloud_use_art : "";
                        var n = {};
                        "" != i.default.soundcloud_client ? (n = e, f.default.loadSoundCloud(n)) : a(e)
                    }
                    v.default.writeMessage("Initialized With: "), v.default.writeMessage(i.default)
                }

                function t() {
                    b.default.initialize(), F.default.displayMetaData()
                }

                function a(e) {
                    e.playlists && d(e.playlists) > 0 && C.default.initialize(e.playlists), void 0 == e.start_song || e.starting_playlist ? E.default.changeSong(i.default.songs[0], 0) : g.default.isInt(e.start_song) ? E.default.changeSong(i.default.songs[e.start_song], e.start_song) : v.default.writeMessage("You must enter an integer index for the start song."), void 0 != e.shuffle_on && e.shuffle_on && (i.default.shuffle_on = !0, _.default.shuffleSongs(), E.default.changeSong(i.default.shuffle_list[0], 0)), i.default.continue_next = void 0 == e.continue_next || e.continue_next, i.default.playback_speed = void 0 != e.playback_speed ? e.playback_speed : 1, s.default.setPlaybackSpeed(i.default.playback_speed), i.default.audio.preload = void 0 != e.preload ? e.preload : "auto", i.default.callbacks = void 0 != e.callbacks ? e.callbacks : {}, i.default.bindings = void 0 != e.bindings ? e.bindings : {}, i.default.volume = void 0 != e.volume ? e.volume : 50, i.default.delay = void 0 != e.delay ? e.delay : 0, i.default.volume_increment = void 0 != e.volume_increment ? e.volume_increment : 5, i.default.volume_decrement = void 0 != e.volume_decrement ? e.volume_decrement : 5, s.default.setVolume(i.default.volume), l(e), n(), void 0 != e.starting_playlist && "" != e.starting_playlist && (i.default.active_playlist = e.starting_playlist, void 0 != e.starting_playlist_song && "" != e.starting_playlist_song ? void 0 != u(e.playlists[e.starting_playlist].songs[parseInt(e.starting_playlist_song)]) ? E.default.changeSongPlaylist(i.default.active_playlist, e.playlists[e.starting_playlist].songs[parseInt(e.starting_playlist_song)], parseInt(e.starting_playlist_song)) : (E.default.changeSongPlaylist(i.default.active_playlist, e.playlists[e.starting_playlist].songs[0], 0), v.default.writeMessage("The index of " + e.starting_playlist_song + " does not exist in the playlist " + e.starting_playlist)) : E.default.changeSong(i.default.active_playlist, e.playlists[e.starting_playlist].songs[0], 0), V.default.sync()), T.default.run("initialized")
                }

                function l(e) {
                    void 0 != e.default_album_art ? i.default.default_album_art = e.default_album_art : i.default.default_album_art = "", void 0 != e.default_playlist_art ? i.default.default_playlist_art = e.default_playlist_art : i.default.default_playlist_art = ""
                }

                function n() {
                    j.default.syncMain(), q.default.setMuted(0 == i.default.volume), H.default.sync(), G.default.sync(), D.default.resetCurrentTimes(), V.default.syncToPause(), F.default.syncMetaData(), X.default.syncRepeatSong()
                }

                function d(e) {
                    var t = 0, a = void 0;
                    for (a in e) e.hasOwnProperty(a) && t++;
                    return v.default.writeMessage("You have " + t + " playlist(s) in your config"), t
                }

                function o() {
                    for (var e = 0; e < i.default.songs.length; e++) void 0 == i.default.songs[e].live && (i.default.songs[e].live = !1)
                }

                function r() {
                    for (var e = 0; e < i.default.songs.length; e++) i.default.songs[e].index = e
                }

                return {initialize: e, setConfig: a, rebindDisplay: t}
            }();
        t.default = J, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e() {
                c = u.default.waveforms.sample_rate;
                var e = document.querySelectorAll(".amplitude-wave-form");
                if (e.length > 0) for (var t = 0; t < e.length; t++) {
                    e[t].innerHTML = "";
                    var a = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                    a.setAttribute("viewBox", "0 -1 " + c + " 2"), a.setAttribute("preserveAspectRatio", "none");
                    var l = document.createElementNS("http://www.w3.org/2000/svg", "g");
                    a.appendChild(l);
                    var n = document.createElementNS("http://www.w3.org/2000/svg", "path");
                    n.setAttribute("d", ""), n.setAttribute("id", "waveform"), l.appendChild(n), e[t].appendChild(a)
                }
            }

            function t() {
                if (u.default.web_audio_api_available) if (void 0 == u.default.waveforms.built[Math.abs(u.default.audio.src.split("").reduce(function (e, t) {
                    return (e = (e << 5) - e + t.charCodeAt(0)) & e
                }, 0))]) {
                    var e = new XMLHttpRequest;
                    e.open("GET", u.default.audio.src, !0), e.responseType = "arraybuffer", e.onreadystatechange = function (t) {
                        4 == e.readyState && 200 == e.status && u.default.context.decodeAudioData(e.response, function (e) {
                            r = e, p = l(c, r), a(c, r, p)
                        })
                    }, e.send()
                } else n(u.default.waveforms.built[Math.abs(u.default.audio.src.split("").reduce(function (e, t) {
                    return (e = (e << 5) - e + t.charCodeAt(0)) & e
                }, 0))])
            }

            function a(e, t, a) {
                if (t) {
                    for (var l = a.length, i = "", d = 0; d < l; d++) i += d % 2 == 0 ? " M" + ~~(d / 2) + ", " + a.shift() : " L" + ~~(d / 2) + ", " + a.shift();
                    u.default.waveforms.built[Math.abs(u.default.audio.src.split("").reduce(function (e, t) {
                        return (e = (e << 5) - e + t.charCodeAt(0)) & e
                    }, 0))] = i, n(u.default.waveforms.built[Math.abs(u.default.audio.src.split("").reduce(function (e, t) {
                        return (e = (e << 5) - e + t.charCodeAt(0)) & e
                    }, 0))])
                }
            }

            function l(e, t) {
                for (var a = t.length / e, l = ~~(a / 10) || 1, u = t.numberOfChannels, n = [], i = 0; i < u; i++) for (var d = [], s = t.getChannelData(i), o = 0; o < e; o++) {
                    for (var f = ~~(o * a), r = ~~(f + a), c = s[0], p = s[0], v = f; v < r; v += l) {
                        var y = s[v];
                        y > p && (p = y), y < c && (c = y)
                    }
                    d[2 * o] = p, d[2 * o + 1] = c, (0 === i || p > n[2 * o]) && (n[2 * o] = p), (0 === i || c < n[2 * o + 1]) && (n[2 * o + 1] = c)
                }
                return n
            }

            function n(e) {
                for (var t = document.querySelectorAll(".amplitude-wave-form"), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist"),
                        u = t[a].getAttribute("data-amplitude-song-index");
                    null == l && null == u && i(t[a], e), null != l && null == u && d(t[a], e, l), null == l && null != u && s(t[a], e, u), null != l && null != u && o(t[a], e, l, u)
                }
            }

            function i(e, t) {
                e.querySelector("svg g path").setAttribute("d", t)
            }

            function d(e, t, a) {
                if (u.default.active_playlist == a) {
                    e.querySelector("svg g path").setAttribute("d", t)
                }
            }

            function s(e, t, a) {
                if (u.default.active_index == a) {
                    e.querySelector("svg g path").setAttribute("d", t)
                }
            }

            function o(e, t, a, l) {
                if (u.default.active_playlist == a && u.default.playlists[u.default.active_playlist].active_index == l) {
                    e.querySelector("svg g path").setAttribute("d", t)
                }
            }

            function f() {
                return document.querySelectorAll(".amplitude-wave-form").length > 0
            }

            var r = "", c = "", p = "";
            return {init: e, build: t, determineIfUsingWaveforms: f}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e() {
                var e = {},
                    t = (Math.floor(u.default.audio.currentTime % 60) < 10 ? "0" : "") + Math.floor(u.default.audio.currentTime % 60),
                    a = Math.floor(u.default.audio.currentTime / 60), l = "00";
                return a < 10 && (a = "0" + a), a >= 60 && (l = Math.floor(a / 60), (a %= 60) < 10 && (a = "0" + a)), e.seconds = t, e.minutes = a, e.hours = l, e
            }

            function t() {
                var e = {},
                    t = (Math.floor(u.default.audio.duration % 60) < 10 ? "0" : "") + Math.floor(u.default.audio.duration % 60),
                    a = Math.floor(u.default.audio.duration / 60), l = "00";
                return a < 10 && (a = "0" + a), a >= 60 && (l = Math.floor(a / 60), (a %= 60) < 10 && (a = "0" + a)), e.seconds = isNaN(t) ? "00" : t, e.minutes = isNaN(a) ? "00" : a, e.hours = isNaN(l) ? "00" : l.toString(), e
            }

            function a() {
                return u.default.audio.currentTime / u.default.audio.duration * 100
            }

            function l(e) {
                u.default.active_metadata.live || isFinite(e) && (u.default.audio.currentTime = e)
            }

            return {
                computeCurrentTimes: e,
                computeSongDuration: t,
                computeSongCompletionPercentage: a,
                setCurrentTime: l
            }
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e() {
                t(), a(), l(), n()
            }

            function t() {
                for (var e = document.getElementsByClassName("amplitude-buffered-progress"), t = 0; t < e.length; t++) {
                    var a = e[t].getAttribute("data-amplitude-playlist"),
                        l = e[t].getAttribute("data-amplitude-song-index");
                    null != a || null != l || isNaN(u.default.buffered) || (e[t].value = parseFloat(parseFloat(u.default.buffered) / 100))
                }
            }

            function a() {
                for (var e = document.querySelectorAll('.amplitude-buffered-progress[data-amplitude-playlist="' + u.default.active_playlist + '"]'), t = 0; t < e.length; t++) {
                    null != e[t].getAttribute("data-amplitude-song-index") || isNaN(u.default.buffered) || (e[t].value = parseFloat(parseFloat(u.default.buffered) / 100))
                }
            }

            function l() {
                for (var e = document.querySelectorAll('.amplitude-buffered-progress[data-amplitude-song-index="' + u.default.active_index + '"]'), t = 0; t < e.length; t++) {
                    null != e[t].getAttribute("data-amplitude-playlist") || isNaN(u.default.buffered) || (e[t].value = parseFloat(parseFloat(u.default.buffered) / 100))
                }
            }

            function n() {
                for (var e = null != u.default.active_playlist && "" != u.default.active_playlist ? u.default.playlists[u.default.active_playlist].active_index : null, t = document.querySelectorAll('.amplitude-buffered-progress[data-amplitude-song-index="' + e + '"][data-amplitude-playlist="' + u.default.active_playlist + '"]'), a = 0; a < t.length; a++) isNaN(u.default.buffered) || (t[a].value = parseFloat(parseFloat(u.default.buffered) / 100))
            }

            function i() {
                for (var e = document.getElementsByClassName("amplitude-buffered-progress"), t = 0; t < e.length; t++) e[t].value = 0
            }

            return {sync: e, reset: i}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(3), d = l(i), s = a(1), o = l(s), f = a(2), r = l(f), c = function () {
            function e() {
                setTimeout(function () {
                    n.default.continue_next ? "" == n.default.active_playlist || null == n.default.active_playlist ? d.default.setNext(!0) : d.default.setNextPlaylist(n.default.active_playlist, !0) : n.default.is_touch_moving || (o.default.stop(), r.default.sync())
                }, n.default.delay)
            }

            return {handle: e}
        }();
        t.default = c, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(27), d = l(i), s = a(42), o = l(s), f = a(25), r = l(f), c = a(35), p = l(c),
            v = a(31), y = l(v), g = a(30), m = l(g), _ = a(32), h = l(_), b = a(41), A = l(b), x = a(28), M = l(x),
            P = a(45), S = l(P), L = a(43), w = l(L), E = a(40), k = l(E), T = a(44), O = l(T), C = a(29), N = l(C),
            j = a(34), I = l(j), q = a(36), z = l(q), H = a(37), B = l(H), D = a(33), R = l(D), V = a(38), U = l(V),
            F = a(39), W = l(F), G = a(22), Y = l(G), X = a(4), J = l(X), $ = function () {
                function e() {
                    J.default.writeMessage("Beginning initialization of event handlers.."), document.addEventListener("touchmove", function () {
                        n.default.is_touch_moving = !0
                    }), document.addEventListener("touchend", function () {
                        n.default.is_touch_moving && (n.default.is_touch_moving = !1)
                    }), t(), a(), l(), u(), i(), s(), f(), c(), v(), g(), _(), b(), x(), P(), L(), E(), T(), C(), j(), q(), H()
                }

                function t() {
                    n.default.audio.removeEventListener("timeupdate", o.default.handle), n.default.audio.addEventListener("timeupdate", o.default.handle), n.default.audio.removeEventListener("durationchange", o.default.handle), n.default.audio.addEventListener("durationchange", o.default.handle)
                }

                function a() {
                    document.removeEventListener("keydown", d.default.handle), document.addEventListener("keydown", d.default.handle)
                }

                function l() {
                    n.default.audio.removeEventListener("ended", r.default.handle), n.default.audio.addEventListener("ended", r.default.handle)
                }

                function u() {
                    n.default.audio.removeEventListener("progress", p.default.handle), n.default.audio.addEventListener("progress", p.default.handle)
                }

                function i() {
                    for (var e = document.getElementsByClassName("amplitude-play"), t = 0; t < e.length; t++) /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? (e[t].removeEventListener("touchend", y.default.handle), e[t].addEventListener("touchend", y.default.handle)) : (e[t].removeEventListener("click", y.default.handle), e[t].addEventListener("click", y.default.handle))
                }

                function s() {
                    for (var e = document.getElementsByClassName("amplitude-pause"), t = 0; t < e.length; t++) /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? (e[t].removeEventListener("touchend", m.default.handle), e[t].addEventListener("touchend", m.default.handle)) : (e[t].removeEventListener("click", m.default.handle), e[t].addEventListener("click", m.default.handle))
                }

                function f() {
                    for (var e = document.getElementsByClassName("amplitude-play-pause"), t = 0; t < e.length; t++) /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? (e[t].removeEventListener("touchend", h.default.handle), e[t].addEventListener("touchend", h.default.handle)) : (e[t].removeEventListener("click", h.default.handle), e[t].addEventListener("click", h.default.handle))
                }

                function c() {
                    for (var e = document.getElementsByClassName("amplitude-stop"), t = 0; t < e.length; t++) /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? (e[t].removeEventListener("touchend", A.default.handle), e[t].addEventListener("touchend", A.default.handle)) : (e[t].removeEventListener("click", A.default.handle), e[t].addEventListener("click", A.default.handle))
                }

                function v() {
                    for (var e = document.getElementsByClassName("amplitude-mute"), t = 0; t < e.length; t++) /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? /iPhone|iPad|iPod/i.test(navigator.userAgent) ? J.default.writeMessage("iOS does NOT allow volume to be set through javascript: https://developer.apple.com/library/safari/documentation/AudioVideo/Conceptual/Using_HTML5_Audio_Video/Device-SpecificConsiderations/Device-SpecificConsiderations.html#//apple_ref/doc/uid/TP40009523-CH5-SW4") : (e[t].removeEventListener("touchend", M.default.handle), e[t].addEventListener("touchend", M.default.handle)) : (e[t].removeEventListener("click", M.default.handle), e[t].addEventListener("click", M.default.handle))
                }

                function g() {
                    for (var e = document.getElementsByClassName("amplitude-volume-up"), t = 0; t < e.length; t++) /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? /iPhone|iPad|iPod/i.test(navigator.userAgent) ? J.default.writeMessage("iOS does NOT allow volume to be set through javascript: https://developer.apple.com/library/safari/documentation/AudioVideo/Conceptual/Using_HTML5_Audio_Video/Device-SpecificConsiderations/Device-SpecificConsiderations.html#//apple_ref/doc/uid/TP40009523-CH5-SW4") : (e[t].removeEventListener("touchend", S.default.handle), e[t].addEventListener("touchend", S.default.handle)) : (e[t].removeEventListener("click", S.default.handle), e[t].addEventListener("click", S.default.handle))
                }

                function _() {
                    for (var e = document.getElementsByClassName("amplitude-volume-down"), t = 0; t < e.length; t++) /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? /iPhone|iPad|iPod/i.test(navigator.userAgent) ? J.default.writeMessage("iOS does NOT allow volume to be set through javascript: https://developer.apple.com/library/safari/documentation/AudioVideo/Conceptual/Using_HTML5_Audio_Video/Device-SpecificConsiderations/Device-SpecificConsiderations.html#//apple_ref/doc/uid/TP40009523-CH5-SW4") : (e[t].removeEventListener("touchend", w.default.handle), e[t].addEventListener("touchend", w.default.handle)) : (e[t].removeEventListener("click", w.default.handle), e[t].addEventListener("click", w.default.handle))
                }

                function b() {
                    for (var e = window.navigator.userAgent, t = e.indexOf("MSIE "), a = document.getElementsByClassName("amplitude-song-slider"), l = 0; l < a.length; l++) t > 0 || navigator.userAgent.match(/Trident.*rv\:11\./) ? (a[l].removeEventListener("change", k.default.handle), a[l].addEventListener("change", k.default.handle)) : (a[l].removeEventListener("input", k.default.handle), a[l].addEventListener("input", k.default.handle))
                }

                function x() {
                    for (var e = window.navigator.userAgent, t = e.indexOf("MSIE "), a = document.getElementsByClassName("amplitude-volume-slider"), l = 0; l < a.length; l++) /iPhone|iPad|iPod/i.test(navigator.userAgent) ? J.default.writeMessage("iOS does NOT allow volume to be set through javascript: https://developer.apple.com/library/safari/documentation/AudioVideo/Conceptual/Using_HTML5_Audio_Video/Device-SpecificConsiderations/Device-SpecificConsiderations.html#//apple_ref/doc/uid/TP40009523-CH5-SW4") : t > 0 || navigator.userAgent.match(/Trident.*rv\:11\./) ? (a[l].removeEventListener("change", O.default.handle), a[l].addEventListener("change", O.default.handle)) : (a[l].removeEventListener("input", O.default.handle), a[l].addEventListener("input", O.default.handle))
                }

                function P() {
                    for (var e = document.getElementsByClassName("amplitude-next"), t = 0; t < e.length; t++) /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? (e[t].removeEventListener("touchend", N.default.handle), e[t].addEventListener("touchend", N.default.handle)) : (e[t].removeEventListener("click", N.default.handle), e[t].addEventListener("click", N.default.handle))
                }

                function L() {
                    for (var e = document.getElementsByClassName("amplitude-prev"), t = 0; t < e.length; t++) /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? (e[t].removeEventListener("touchend", I.default.handle), e[t].addEventListener("touchend", I.default.handle)) : (e[t].removeEventListener("click", I.default.handle), e[t].addEventListener("click", I.default.handle))
                }

                function E() {
                    for (var e = document.getElementsByClassName("amplitude-shuffle"), t = 0; t < e.length; t++) e[t].classList.remove("amplitude-shuffle-on"), e[t].classList.add("amplitude-shuffle-off"), /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? (e[t].removeEventListener("touchend", U.default.handle), e[t].addEventListener("touchend", U.default.handle)) : (e[t].removeEventListener("click", U.default.handle), e[t].addEventListener("click", U.default.handle))
                }

                function T() {
                    for (var e = document.getElementsByClassName("amplitude-repeat"), t = 0; t < e.length; t++) e[t].classList.remove("amplitude-repeat-on"), e[t].classList.add("amplitude-repeat-off"), /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? (e[t].removeEventListener("touchend", z.default.handle), e[t].addEventListener("touchend", z.default.handle)) : (e[t].removeEventListener("click", z.default.handle), e[t].addEventListener("click", z.default.handle))
                }

                function C() {
                    for (var e = document.getElementsByClassName("amplitude-repeat-song"), t = 0; t < e.length; t++) e[t].classList.remove("amplitude-repeat-on"), e[t].classList.add("amplitude-repeat-off"), /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? (e[t].removeEventListener("touchend", B.default.handle), e[t].addEventListener("touchend", B.default.handle)) : (e[t].removeEventListener("click", B.default.handle), e[t].addEventListener("click", B.default.handle))
                }

                function j() {
                    for (var e = document.getElementsByClassName("amplitude-playback-speed"), t = 0; t < e.length; t++) /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? (e[t].removeEventListener("touchend", R.default.handle), e[t].addEventListener("touchend", R.default.handle)) : (e[t].removeEventListener("click", R.default.handle), e[t].addEventListener("click", R.default.handle))
                }

                function q() {
                    for (var e = document.getElementsByClassName("amplitude-skip-to"), t = 0; t < e.length; t++) /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? (e[t].removeEventListener("touchend", W.default.handle), e[t].addEventListener("touchend", W.default.handle)) : (e[t].removeEventListener("click", W.default.handle), e[t].addEventListener("click", W.default.handle))
                }

                function H() {
                    Y.default.determineIfUsingWaveforms() && (n.default.audio.removeEventListener("canplaythrough", Y.default.build), n.default.audio.addEventListener("canplaythrough", Y.default.build))
                }

                return {initialize: e}
            }();
        t.default = $, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(1), d = l(i), s = a(13), o = l(s), f = a(12), r = l(f), c = a(3), p = l(c),
            v = a(8), y = l(v), g = a(2), m = l(g), _ = function () {
                function e(e) {
                    t(e.which)
                }

                function t(e) {
                    if (void 0 != n.default.bindings[e]) switch (n.default.bindings[e]) {
                        case"play_pause":
                            a();
                            break;
                        case"next":
                            l();
                            break;
                        case"prev":
                            u();
                            break;
                        case"stop":
                            i();
                            break;
                        case"shuffle":
                            s();
                            break;
                        case"repeat":
                            f()
                    }
                }

                function a() {
                    n.default.audio.paused ? d.default.play() : d.default.pause(), m.default.sync()
                }

                function l() {
                    "" == n.default.active_playlist || null == n.default.active_playlist ? p.default.setNext() : p.default.setNextPlaylist(n.default.active_playlist)
                }

                function u() {
                    "" == n.default.active_playlist || null == n.default.active_playlist ? p.default.setPrevious() : p.default.setPreviousPlaylist(n.default.active_playlist)
                }

                function i() {
                    m.default.syncToPause(), d.default.stop()
                }

                function s() {
                    "" == n.default.active_playlist || null == n.default.active_playlist ? o.default.toggleShuffle() : o.default.toggleShufflePlaylist(n.default.active_playlist)
                }

                function f() {
                    r.default.setRepeat(!n.default.repeat), y.default.syncRepeat()
                }

                return {handle: e}
            }();
        t.default = _, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(1), d = l(i), s = a(10), o = l(s), f = a(11), r = l(f), c = function () {
            function e() {
                n.default.is_touch_moving || (0 == n.default.volume ? d.default.setVolume(n.default.pre_mute_volume) : (n.default.pre_mute_volume = n.default.volume, d.default.setVolume(0)), o.default.setMuted(0 == n.default.volume), r.default.sync())
            }

            return {handle: e}
        }();
        t.default = c, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(1), d = (l(i), a(2)), s = (l(d), a(9)), o = (l(s), a(3)), f = l(o), r = a(4),
            c = l(r), p = function () {
                function e() {
                    if (!n.default.is_touch_moving) {
                        var e = this.getAttribute("data-amplitude-playlist");
                        null == e && t(), null != e && a(e)
                    }
                }

                function t() {
                    "" == n.default.active_playlist || null == n.default.active_playlist ? f.default.setNext() : f.default.setNextPlaylist(n.default.active_playlist)
                }

                function a(e) {
                    e == n.default.active_playlist ? f.default.setNextPlaylist(e) : c.default.writeMessage("You can not go to the next song on a playlist that is not being played!")
                }

                return {handle: e}
            }();
        t.default = p, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(6), d = (l(i), a(1)), s = l(d), o = a(2), f = l(o), r = function () {
            function e() {
                if (!n.default.is_touch_moving) {
                    var e = this.getAttribute("data-amplitude-song-index"),
                        i = this.getAttribute("data-amplitude-playlist");
                    null == i && null == e && t(), null != i && null == e && a(i), null == i && null != e && l(e), null != i && null != e && u(i, e)
                }
            }

            function t() {
                s.default.pause(), f.default.sync()
            }

            function a(e) {
                n.default.active_playlist == e && (s.default.pause(), f.default.sync())
            }

            function l(e) {
                "" != n.default.active_playlist && null != n.default.active_playlist || n.default.active_index != e || (s.default.pause(), f.default.sync())
            }

            function u(e, t) {
                n.default.active_playlist == e && n.default.playlists[e].active_index == t && (s.default.pause(), f.default.sync())
            }

            return {handle: e}
        }();
        t.default = r, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(6), d = (l(i), a(1)), s = l(d), o = a(5), f = l(o), r = a(3), c = l(r), p = a(2),
            v = l(p), y = function () {
                function e() {
                    if (!n.default.is_touch_moving) {
                        var e = this.getAttribute("data-amplitude-song-index"),
                            i = this.getAttribute("data-amplitude-playlist");
                        null == i && null == e && t(), null != i && null == e && a(i), null == i && null != e && l(e), null != i && null != e && u(i, e)
                    }
                }

                function t() {
                    s.default.play(), v.default.sync()
                }

                function a(e) {
                    f.default.newPlaylist(e) && (c.default.setActivePlaylist(e), n.default.playlists[e].shuffle ? c.default.changeSongPlaylist(e, n.default.playlists[e].shuffle_list[0], 0) : c.default.changeSongPlaylist(e, n.default.playlists[e].songs[0], 0)), s.default.play(), v.default.sync()
                }

                function l(e) {
                    f.default.newPlaylist(null) && (c.default.setActivePlaylist(null), c.default.changeSong(n.default.songs[e], e)), f.default.newSong(null, e) && c.default.changeSong(n.default.songs[e], e), s.default.play(), v.default.sync()
                }

                function u(e, t) {
                    f.default.newPlaylist(e) && (c.default.setActivePlaylist(e), c.default.changeSongPlaylist(e, n.default.playlists[e].songs[t], t)), f.default.newSong(e, t) && c.default.changeSongPlaylist(e, n.default.playlists[e].songs[t], t), s.default.play(), v.default.sync()
                }

                return {handle: e}
            }();
        t.default = y, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(6), d = (l(i), a(1)), s = l(d), o = a(5), f = l(o), r = a(3), c = l(r), p = a(2),
            v = l(p), y = function () {
                function e() {
                    if (!n.default.is_touch_moving) {
                        var e = this.getAttribute("data-amplitude-playlist"),
                            i = this.getAttribute("data-amplitude-song-index");
                        null == e && null == i && t(), null != e && null == i && a(e), null == e && null != i && l(i), null != e && null != i && u(e, i)
                    }
                }

                function t() {
                    n.default.audio.paused ? s.default.play() : s.default.pause(), v.default.sync()
                }

                function a(e) {
                    f.default.newPlaylist(e) && (c.default.setActivePlaylist(e), n.default.playlists[e].shuffle ? c.default.changeSongPlaylist(e, n.default.playlists[e].shuffle_list[0], 0, !0) : c.default.changeSongPlaylist(e, n.default.playlists[e].songs[0], 0)), n.default.audio.paused ? s.default.play() : s.default.pause(), v.default.sync()
                }

                function l(e) {
                    f.default.newPlaylist(null) && (c.default.setActivePlaylist(null), c.default.changeSong(n.default.songs[e], e, !0)), f.default.newSong(null, e) && c.default.changeSong(n.default.songs[e], e, !0), n.default.audio.paused ? s.default.play() : s.default.pause(), v.default.sync()
                }

                function u(e, t) {
                    f.default.newPlaylist(e) && (c.default.setActivePlaylist(e), c.default.changeSongPlaylist(e, n.default.playlists[e].songs[t], t, !0)), f.default.newSong(e, t) && c.default.changeSongPlaylist(e, n.default.playlists[e].songs[t], t, !0), n.default.audio.paused ? s.default.play() : s.default.pause(), v.default.sync()
                }

                return {handle: e}
            }();
        t.default = y, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(1), d = l(i), s = a(18), o = l(s), f = function () {
            function e() {
                if (!n.default.is_touch_moving) {
                    switch (n.default.playback_speed) {
                        case 1:
                            d.default.setPlaybackSpeed(1.5);
                            break;
                        case 1.5:
                            d.default.setPlaybackSpeed(2);
                            break;
                        case 2:
                            d.default.setPlaybackSpeed(1)
                    }
                    o.default.sync()
                }
            }

            return {handle: e}
        }();
        t.default = f, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(3), d = l(i), s = a(4), o = l(s), f = function () {
            function e() {
                if (!n.default.is_touch_moving) {
                    var e = this.getAttribute("data-amplitude-playlist");
                    null == e && t(), null != e && a(e)
                }
            }

            function t() {
                "" == n.default.active_playlist || null == n.default.active_playlist ? d.default.setPrevious() : d.default.setPreviousPlaylist(n.default.active_playlist)
            }

            function a(e) {
                e == n.default.active_playlist ? d.default.setPreviousPlaylist(n.default.active_playlist) : o.default.writeMessage("You can not go to the previous song on a playlist that is not being played!")
            }

            return {handle: e}
        }();
        t.default = f, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(24), d = l(i), s = function () {
            function e() {
                if (n.default.audio.buffered.length - 1 >= 0) {
                    var e = n.default.audio.buffered.end(n.default.audio.buffered.length - 1),
                        t = n.default.audio.duration;
                    n.default.buffered = e / t * 100
                }
                d.default.sync()
            }

            return {handle: e}
        }();
        t.default = s, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(12), d = l(i), s = a(8), o = l(s), f = function () {
            function e() {
                if (!n.default.is_touch_moving) {
                    var e = this.getAttribute("data-amplitude-playlist");
                    null == e && t(), null != e && a(e)
                }
            }

            function t() {
                d.default.setRepeat(!n.default.repeat), o.default.syncRepeat()
            }

            function a(e) {
                d.default.setRepeatPlaylist(!n.default.playlists[e].repeat, e), o.default.syncRepeatPlaylist(e)
            }

            return {handle: e}
        }();
        t.default = f, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(12), d = l(i), s = a(8), o = l(s), f = function () {
            function e() {
                n.default.is_touch_moving || (d.default.setRepeatSong(!n.default.repeat_song), o.default.syncRepeatSong())
            }

            return {handle: e}
        }();
        t.default = f, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(13), d = l(i), s = a(19), o = l(s), f = function () {
            function e() {
                if (!n.default.is_touch_moving) {
                    var e = this.getAttribute("data-amplitude-playlist");
                    null == e ? t() : a(e)
                }
            }

            function t() {
                d.default.toggleShuffle(), o.default.syncMain(n.default.shuffle_on)
            }

            function a(e) {
                d.default.toggleShufflePlaylist(e), o.default.syncPlaylist(e)
            }

            return {handle: e}
        }();
        t.default = f, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(4), d = l(i), s = a(3), o = l(s), f = a(5), r = l(f), c = a(1), p = l(c),
            v = a(2), y = l(v), g = function () {
                function e() {
                    if (!n.default.is_touch_moving) {
                        var e = this.getAttribute("data-amplitude-playlist"),
                            l = this.getAttribute("data-amplitude-song-index"),
                            u = this.getAttribute("data-amplitude-location");
                        null == u && d.default.writeMessage("You must add an 'data-amplitude-location' attribute in seconds to your 'amplitude-skip-to' element."), null == l && d.default.writeMessage("You must add an 'data-amplitude-song-index' attribute to your 'amplitude-skip-to' element."), null != u && null != l && (null == e ? t(parseInt(l), parseInt(u)) : a(e, parseInt(l), parseInt(u)))
                    }
                }

                function t(e, t) {
                    o.default.changeSong(n.default.songs[e], e), p.default.play(), y.default.syncGlobal(), y.default.syncSong(), p.default.skipToLocation(t)
                }

                function a(e, t, a) {
                    r.default.newPlaylist(e) && o.default.setActivePlaylist(e), o.default.changeSongPlaylist(e, n.default.playlists[e].songs[t], t), p.default.play(), y.default.syncGlobal(), y.default.syncPlaylist(), y.default.syncSong(), p.default.skipToLocation(a)
                }

                return {handle: e}
            }();
        t.default = g, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(23), d = l(i), s = a(14), o = l(s), f = function () {
            function e() {
                var e = this.value, i = n.default.audio.duration * (e / 100),
                    d = this.getAttribute("data-amplitude-playlist"),
                    s = this.getAttribute("data-amplitude-song-index");
                null == d && null == s && t(i, e), null != d && null == s && a(i, e, d), null == d && null != s && l(i, e, s), null != d && null != s && u(i, e, d, s)
            }

            function t(e, t) {
                n.default.active_metadata.live || (d.default.setCurrentTime(e), o.default.sync(t, n.default.active_playlist, n.default.active_index))
            }

            function a(e, t, a) {
                n.default.active_playlist == a && (n.default.active_metadata.live || (d.default.setCurrentTime(e), o.default.sync(t, a, n.default.active_index)))
            }

            function l(e, t, a) {
                n.default.active_index == a && null == n.default.active_playlist && (n.default.active_metadata.live || (d.default.setCurrentTime(e), o.default.sync(t, n.default.active_playlist, a)))
            }

            function u(e, t, a, l) {
                n.default.playlists[a].active_index == l && n.default.active_playlist == a && (n.default.active_metadata.live || (d.default.setCurrentTime(e), o.default.sync(t, a, l)))
            }

            return {handle: e}
        }();
        t.default = f, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(6), d = (l(i), a(2)), s = l(d), o = a(1), f = l(o), r = function () {
            function e() {
                n.default.is_touch_moving || (s.default.syncToPause(), f.default.stop())
            }

            return {handle: e}
        }();
        t.default = r, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(24), d = l(i), s = a(15), o = l(s), f = a(14), r = l(f), c = a(20), p = l(c),
            v = a(23), y = l(v), g = a(9), m = (l(g), function () {
                function e() {
                    t(), d.default.sync(), a(), l()
                }

                function t() {
                    if (n.default.audio.buffered.length - 1 >= 0) {
                        var e = n.default.audio.buffered.end(n.default.audio.buffered.length - 1),
                            t = n.default.audio.duration;
                        n.default.buffered = e / t * 100
                    }
                }

                function a() {
                    if (!n.default.active_metadata.live) {
                        var e = y.default.computeCurrentTimes(), t = y.default.computeSongCompletionPercentage(),
                            a = y.default.computeSongDuration();
                        o.default.syncCurrentTimes(e), r.default.sync(t, n.default.active_playlist, n.default.active_index), p.default.sync(t), o.default.syncDurationTimes(e, a)
                    }
                }

                function l() {
                    var e = Math.floor(n.default.audio.currentTime);
                    if (void 0 != n.default.active_metadata.time_callbacks && void 0 != n.default.active_metadata.time_callbacks[e]) n.default.active_metadata.time_callbacks[e].run || (n.default.active_metadata.time_callbacks[e].run = !0, n.default.active_metadata.time_callbacks[e]()); else for (var t in n.default.active_metadata.time_callbacks) n.default.active_metadata.time_callbacks.hasOwnProperty(t) && (n.default.active_metadata.time_callbacks[t].run = !1)
                }

                return {handle: e}
            }());
        t.default = m, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(1), d = l(i), s = a(10), o = l(s), f = a(11), r = l(f), c = function () {
            function e() {
                if (!n.default.is_touch_moving) {
                    var e = null;
                    e = n.default.volume - n.default.volume_increment > 0 ? n.default.volume - n.default.volume_increment : 0, d.default.setVolume(e), o.default.setMuted(0 == n.default.volume), r.default.sync()
                }
            }

            return {handle: e}
        }();
        t.default = c, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(1), d = l(i), s = a(10), o = l(s), f = a(11), r = l(f), c = function () {
            function e() {
                d.default.setVolume(this.value), o.default.setMuted(0 == n.default.volume), r.default.sync()
            }

            return {handle: e}
        }();
        t.default = c, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(1), d = l(i), s = a(10), o = l(s), f = a(11), r = l(f), c = function () {
            function e() {
                if (!n.default.is_touch_moving) {
                    var e = null;
                    e = n.default.volume + n.default.volume_increment <= 100 ? n.default.volume + n.default.volume_increment : 100, d.default.setVolume(e), o.default.setMuted(0 == n.default.volume), r.default.sync()
                }
            }

            return {handle: e}
        }();
        t.default = c, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e() {
                var e = window.AudioContext || window.webkitAudioContext || window.mozAudioContext || window.oAudioContext || window.msAudioContext;
                e ? (u.default.context = new e, u.default.analyser = u.default.context.createAnalyser(), u.default.audio.crossOrigin = "anonymous", u.default.source = u.default.context.createMediaElementSource(u.default.audio), u.default.source.connect(u.default.analyser), u.default.analyser.connect(u.default.context.destination)) : AmplitudeHelpers.writeDebugMessage("Web Audio API is unavailable! We will set any of your visualizations with your back up definition!")
            }

            function t() {
                var e = window.AudioContext || window.webkitAudioContext || window.mozAudioContext || window.oAudioContext || window.msAudioContext;
                return u.default.web_audio_api_available = !1, e ? (u.default.web_audio_api_available = !0, !0) : (u.default.web_audio_api_available = !1, !1)
            }

            function a() {
                var e = document.querySelectorAll(".amplitude-wave-form"),
                    t = document.querySelectorAll(".amplitude-visualization");
                return e.length > 0 || t.length > 0
            }

            return {configureWebAudioAPI: e, webAudioAPIAvailable: t, determineUsingAnyFX: a}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(21), n = l(u), i = a(0), d = l(i), s = a(1), o = l(s), f = a(13), r = l(f), c = a(6),
            p = (l(c), a(3)), v = l(p), y = a(12), g = l(y), m = a(5), _ = l(m), h = a(16), b = l(h), A = a(19),
            x = l(A), M = a(8), P = l(M), S = a(14), L = l(S), w = a(20), E = l(w), k = a(15), T = l(k), O = a(2),
            C = l(O), N = a(7), j = l(N), I = a(18), q = l(I), z = a(4), H = l(z), B = a(17), D = l(B),
            R = function () {
                function e(e) {
                    n.default.initialize(e)
                }

                function t() {
                    return d.default
                }

                function a() {
                    n.default.rebindDisplay()
                }

                function l() {
                    return d.default.active_playlist
                }

                function u() {
                    return d.default.playback_speed
                }

                function i(e) {
                    o.default.setPlaybackSpeed(e), q.default.sync()
                }

                function s() {
                    return d.default.repeat
                }

                function f(e) {
                    return d.default.playlists[e].repeat
                }

                function c() {
                    return d.default.shuffle_on
                }

                function p(e) {
                    return d.default.playlists[e].shuffle
                }

                function y(e) {
                    r.default.setShuffle(e), x.default.syncMain()
                }

                function m(e, t) {
                    r.default.setShufflePlaylist(e, t), x.default.syncMain(), x.default.syncPlaylist(e)
                }

                function h(e) {
                    g.default.setRepeat(e), P.default.syncRepeat()
                }

                function A(e, t) {
                    g.default.setRepeatPlaylist(t, e), P.default.syncRepeatPlaylist(e)
                }

                function M(e) {
                    d.default.is_touch_moving || (g.default.setRepeatSong(!d.default.repeat_song), P.default.syncRepeatSong())
                }

                function S() {
                    return d.default.default_album_art
                }

                function w() {
                    return d.default.default_playlist_art
                }

                function k(e) {
                    d.default.default_album_art = e
                }

                function O(e) {
                    d.default.default_plalist_art = e
                }

                function N() {
                    return d.default.audio.currentTime / d.default.audio.duration * 100
                }

                function I() {
                    return d.default.audio.currentTime
                }

                function z() {
                    return d.default.audio.duration
                }

                function B(e) {
                    "number" == typeof e && e > 0 && e < 100 && (d.default.audio.currentTime = d.default.audio.duration * (e / 100))
                }

                function R(e) {
                    d.default.debug = e
                }

                function V() {
                    return d.default.active_metadata
                }

                function U() {
                    return d.default.playlists[d.default.active_playlist]
                }

                function F(e) {
                    return d.default.songs[e]
                }

                function W(e, t) {
                    return d.default.playlists[e].songs[t]
                }

                function G(e) {
                    return void 0 == d.default.songs && (d.default.songs = []), d.default.songs.push(e), d.default.shuffle_on && d.default.shuffle_list.push(e), D.default.isSoundCloudURL(e.url) && D.default.resolveIndividualStreamableURL(e.url, null, d.default.songs.length - 1, d.default.shuffle_on), d.default.songs.length - 1
                }

                function Y(e) {
                    return void 0 == d.default.songs && (d.default.songs = []), d.default.songs.unshift(e), d.default.shuffle_on && d.default.shuffle_list.unshift(e), D.default.isSoundCloudURL(e.url) && D.default.resolveIndividualStreamableURL(e.url, null, d.default.songs.length - 1, d.default.shuffle_on), 0
                }

                function X(e, t) {
                    return void 0 != d.default.playlists[t] ? (d.default.playlists[t].songs.push(e), d.default.playlists[t].shuffle && d.default.playlists[t].shuffle_list.push(e), D.default.isSoundCloudURL(e.url) && D.default.resolveIndividualStreamableURL(e.url, t, d.default.playlists[t].songs.length - 1, d.default.playlists[t].shuffle), d.default.playlists[t].songs.length - 1) : (H.default.writeMessage("Playlist doesn't exist!"), null)
                }

                function J(e, t, a) {
                    if (void 0 == d.default.playlists[e]) {
                        d.default.playlists[e] = {};
                        var l = ["repeat", "shuffle", "shuffle_list", "songs", "src"];
                        for (var u in t) l.indexOf(u) < 0 && (d.default.playlists[e][u] = t[u]);
                        return d.default.playlists[e].songs = a, d.default.playlists[e].active_index = null, d.default.playlists[e].repeat = !1, d.default.playlists[e].shuffle = !1, d.default.playlists[e].shuffle_list = [], d.default.playlists[e]
                    }
                    return H.default.writeMessage("A playlist already exists with that key!"), null
                }

                function $(e) {
                    d.default.songs.splice(e, 1)
                }

                function Q(e, t) {
                    void 0 != d.default.playlists[t] && d.default.playlists[t].songs.splice(e, 1)
                }

                function K(e) {
                    e.url ? (d.default.audio.src = e.url, d.default.active_metadata = e, d.default.active_album = e.album) : H.default.writeMessage("The song needs to have a URL!"), o.default.play(), C.default.sync(), j.default.displayMetaData(), L.default.resetElements(), E.default.resetElements(), T.default.resetCurrentTimes(), T.default.resetDurationTimes()
                }

                function Z(e) {
                    o.default.stop(), _.default.newPlaylist(null) && (v.default.setActivePlaylist(null), v.default.changeSong(d.default.songs[e], e)), _.default.newSong(null, e) && v.default.changeSong(d.default.songs[e], e), o.default.play(), C.default.sync()
                }

                function ee(e, t) {
                    o.default.stop(), _.default.newPlaylist(t) && (v.default.setActivePlaylist(t), v.default.changeSongPlaylist(t, d.default.playlists[t].songs[e], e)), _.default.newSong(t, e) && v.default.changeSongPlaylist(t, d.default.playlists[t].songs[e], e), C.default.sync(), o.default.play()
                }

                function te() {
                    o.default.play()
                }

                function ae() {
                    o.default.pause()
                }

                function le() {
                    o.default.stop()
                }

                function ue() {
                    return d.default.audio
                }

                function ne() {
                    return d.default.analyser
                }

                function ie() {
                    var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : null;
                    "" == e || null == e ? null == d.default.active_playlist || "" == d.default.active_playlist ? v.default.setNext() : v.default.setNextPlaylist(d.default.active_playlist) : v.default.setNextPlaylist(e)
                }

                function de() {
                    var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : null;
                    "" == e || null == e ? null == d.default.active_playlist || "" == d.default.active_playlist ? v.default.setPrevious() : v.default.setPreviousPlaylist(d.default.active_playlist) : v.default.setPreviousPlaylist(e)
                }

                function se() {
                    return d.default.songs
                }

                function oe(e) {
                    return d.default.playlists[e].songs
                }

                function fe() {
                    return d.default.shuffle_on ? d.default.shuffle_list : d.default.songs
                }

                function re(e) {
                    return d.default.playlists[e].shuffle ? d.default.playlists[e].shuffle_list : d.default.playlists[e].songs
                }

                function ce() {
                    return parseInt(d.default.active_index)
                }

                function pe() {
                    return d.default.version
                }

                function ve() {
                    return d.default.buffered
                }

                function ye(e, t) {
                    var a = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : null;
                    e = parseInt(e), null != a ? (_.default.newPlaylist(a) && v.default.setActivePlaylist(a), v.default.changeSongPlaylist(a, d.default.playlists[a].songs[t], t), o.default.play(), C.default.syncGlobal(), C.default.syncPlaylist(), C.default.syncSong(), o.default.skipToLocation(e)) : (v.default.changeSong(d.default.songs[t], t), o.default.play(), C.default.syncGlobal(), C.default.syncSong(), o.default.skipToLocation(e))
                }

                function ge(e, t) {
                    var a = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : null;
                    if ("" != a && null != a && void 0 != d.default.playlists[a]) for (var l in t) t.hasOwnProperty(l) && "url" != l && "URL" != l && "live" != l && "LIVE" != l && (d.default.playlists[a].songs[e][l] = t[l]); else for (var l in t) t.hasOwnProperty(l) && "url" != l && "URL" != l && "live" != l && "LIVE" != l && (d.default.songs[e][l] = t[l]);
                    j.default.displayMetaData(), j.default.syncMetaData()
                }

                function me(e, t) {
                    if (void 0 != d.default.playlists[e]) {
                        var a = ["repeat", "shuffle", "shuffle_list", "songs", "src"];
                        for (var l in t) t.hasOwnProperty(l) && a.indexOf(l) < 0 && (d.default.playlists[e][l] = t[l]);
                        j.default.displayPlaylistMetaData()
                    } else H.default.writeMessage("You must provide a valid playlist key!")
                }

                function _e(e) {
                    d.default.delay = e
                }

                function he() {
                    return d.default.delay
                }

                function be() {
                    return d.default.player_state
                }

                function Ae(e, t) {
                    b.default.register(e, t)
                }

                function xe(e, t) {
                    void 0 != d.default.playlists[e] ? void 0 != d.default.visualizations.available[t] ? d.default.playlists[e].visualization = t : H.default.writeMessage("A visualization does not exist for the key provided.") : H.default.writeMessage("The playlist for the key provided does not exist")
                }

                function Me(e, t) {
                    d.default.songs[e] ? void 0 != d.default.visualizations.available[t] ? d.default.songs[e].visualization = t : H.default.writeMessage("A visualization does not exist for the key provided.") : H.default.writeMessage("A song at that index is undefined")
                }

                function Pe(e, t, a) {
                    void 0 != d.default.playlists[e].songs[t] ? void 0 != d.default.visualizations.available[a] ? d.default.playlists[e].songs[t].visualization = a : H.default.writeMessage("A visualization does not exist for the key provided.") : H.default.writeMessage("The song in the playlist at that key is not defined")
                }

                function Se(e) {
                    void 0 != d.default.visualizations.available[e] ? d.default.visualization = e : H.default.writeMessage("A visualization does not exist for the key provided.")
                }

                function Le(e) {
                    o.default.setVolume(e)
                }

                function we() {
                    return d.default.volume
                }

                return {
                    init: e,
                    getConfig: t,
                    bindNewElements: a,
                    getActivePlaylist: l,
                    getPlaybackSpeed: u,
                    setPlaybackSpeed: i,
                    getRepeat: s,
                    getRepeatPlaylist: f,
                    getShuffle: c,
                    getShufflePlaylist: p,
                    setShuffle: y,
                    setShufflePlaylist: m,
                    setRepeat: h,
                    setRepeatSong: M,
                    setRepeatPlaylist: A,
                    getDefaultAlbumArt: S,
                    setDefaultAlbumArt: k,
                    getDefaultPlaylistArt: w,
                    setDefaultPlaylistArt: O,
                    getSongPlayedPercentage: N,
                    setSongPlayedPercentage: B,
                    getSongPlayedSeconds: I,
                    getSongDuration: z,
                    setDebug: R,
                    getActiveSongMetadata: V,
                    getActivePlaylistMetadata: U,
                    getSongAtIndex: F,
                    getSongAtPlaylistIndex: W,
                    addSong: G,
                    prependSong: Y,
                    addSongToPlaylist: X,
                    removeSong: $,
                    removeSongFromPlaylist: Q,
                    playNow: K,
                    playSongAtIndex: Z,
                    playPlaylistSongAtIndex: ee,
                    play: te,
                    pause: ae,
                    stop: le,
                    getAudio: ue,
                    getAnalyser: ne,
                    next: ie,
                    prev: de,
                    getSongs: se,
                    getSongsInPlaylist: oe,
                    getSongsState: fe,
                    getSongsStatePlaylist: re,
                    getActiveIndex: ce,
                    getVersion: pe,
                    getBuffered: ve,
                    skipTo: ye,
                    setSongMetaData: ge,
                    setPlaylistMetaData: me,
                    setDelay: _e,
                    getDelay: he,
                    getPlayerState: be,
                    addPlaylist: J,
                    registerVisualization: Ae,
                    setPlaylistVisualization: xe,
                    setSongVisualization: Me,
                    setSongInPlaylistVisualization: Pe,
                    setGlobalVisualization: Se,
                    getVolume: we,
                    setVolume: Le
                }
            }();
        t.default = R, e.exports = t.default
    }, function (e, t, a) {
        "use strict";

        function l(e) {
            return e && e.__esModule ? e : {default: e}
        }

        Object.defineProperty(t, "__esModule", {value: !0});
        var u = a(0), n = l(u), i = a(4), d = l(i), s = a(5), o = l(s), f = a(7), r = l(f), c = a(17), p = l(c),
            v = function () {
                function e(e) {
                    n.default.playlists = e, a(), l(), t(), u(), i(), s(), f()
                }

                function t() {
                    for (var e in n.default.playlists) n.default.playlists[e].active_index = null
                }

                function a() {
                    for (var e in n.default.playlists) if (n.default.playlists.hasOwnProperty(e) && n.default.playlists[e].songs) for (var t = 0; t < n.default.playlists[e].songs.length; t++) o.default.isInt(n.default.playlists[e].songs[t]) && (n.default.playlists[e].songs[t] = n.default.songs[n.default.playlists[e].songs[t]], n.default.playlists[e].songs[t].index = t), o.default.isInt(n.default.playlists[e].songs[t]) && !n.default.songs[n.default.playlists[e].songs[t]] && d.default.writeMessage("The song index: " + n.default.playlists[e].songs[t] + " in playlist with key: " + e + " is not defined in your songs array!"), o.default.isInt(n.default.playlists[e].songs[t]) || (n.default.playlists[e].songs[t].index = t)
                }

                function l() {
                    for (var e in n.default.playlists) if (n.default.playlists.hasOwnProperty(e)) for (var t = 0; t < n.default.playlists[e].songs.length; t++) p.default.isSoundCloudURL(n.default.playlists[e].songs[t].url) && void 0 == n.default.playlists[e].songs[t].soundcloud_data && p.default.resolveIndividualStreamableURL(n.default.playlists[e].songs[t].url, e, t)
                }

                function u() {
                    for (var e in n.default.playlists) n.default.playlists[e].shuffle = !1
                }

                function i() {
                    for (var e in n.default.playlists) n.default.playlists[e].repeat = !1
                }

                function s() {
                    for (var e in n.default.playlists) n.default.playlists[e].shuffle_list = []
                }

                function f() {
                    for (var e in n.default.playlists) r.default.setFirstSongInPlaylist(n.default.playlists[e].songs[0], e)
                }

                return {initialize: e}
            }();
        t.default = v, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e(e) {
                for (var t = document.getElementsByClassName("amplitude-song-container"), a = 0; a < t.length; a++) t[a].classList.remove("amplitude-active-song-container");
                if ("" == u.default.active_playlist || null == u.default.active_playlist) {
                    var l = "";
                    if (l = e ? u.default.active_index : u.default.shuffle_on ? u.default.shuffle_list[u.default.active_index].index : u.default.active_index, document.querySelectorAll('.amplitude-song-container[data-amplitude-song-index="' + l + '"]')) for (var n = document.querySelectorAll('.amplitude-song-container[data-amplitude-song-index="' + l + '"]'), i = 0; i < n.length; i++) n[i].hasAttribute("data-amplitude-playlist") || n[i].classList.add("amplitude-active-song-container")
                } else {
                    if (null != u.default.active_playlist && "" != u.default.active_playlist || e) var d = u.default.playlists[u.default.active_playlist].active_index; else {
                        var d = "";
                        d = u.default.playlists[u.default.active_playlist].shuffle ? u.default.playlists[u.default.active_playlist].shuffle_list[u.default.playlists[u.default.active_playlist].active_index].index : u.default.playlists[u.default.active_playlist].active_index
                    }
                    if (document.querySelectorAll('.amplitude-song-container[data-amplitude-song-index="' + d + '"][data-amplitude-playlist="' + u.default.active_playlist + '"]')) for (var s = document.querySelectorAll('.amplitude-song-container[data-amplitude-song-index="' + d + '"][data-amplitude-playlist="' + u.default.active_playlist + '"]'), o = 0; o < s.length; o++) s[o].classList.add("amplitude-active-song-container")
                }
            }

            return {setActive: e}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e(e) {
                t(e), a(e), l(e), n(e)
            }

            function t(e) {
                for (var t = document.querySelectorAll(".amplitude-current-hours"), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist"),
                        u = t[a].getAttribute("data-amplitude-song-index");
                    null == l && null == u && (t[a].innerHTML = e)
                }
            }

            function a(e) {
                for (var t = document.querySelectorAll('.amplitude-current-hours[data-amplitude-playlist="' + u.default.active_playlist + '"]'), a = 0; a < t.length; a++) {
                    null == t[a].getAttribute("data-amplitude-song-index") && (t[a].innerHTML = e)
                }
            }

            function l(e) {
                if (null == u.default.active_playlist) for (var t = document.querySelectorAll('.amplitude-current-hours[data-amplitude-song-index="' + u.default.active_index + '"]'), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist");
                    null == l && (t[a].innerHTML = e)
                }
            }

            function n(e) {
                for (var t = "" != u.default.active_playlist && null != u.default.active_playlist ? u.default.playlists[u.default.active_playlist].active_index : null, a = document.querySelectorAll('.amplitude-current-hours[data-amplitude-playlist="' + u.default.active_playlist + '"][data-amplitude-song-index="' + t + '"]'), l = 0; l < a.length; l++) a[l].innerHTML = e
            }

            function i() {
                for (var e = document.querySelectorAll(".amplitude-current-hours"), t = 0; t < e.length; t++) e[t].innerHTML = "00"
            }

            return {sync: e, resetTimes: i}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e(e) {
                t(e), a(e), l(e), n(e)
            }

            function t(e) {
                for (var t = document.querySelectorAll(".amplitude-current-minutes"), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist"),
                        u = t[a].getAttribute("data-amplitude-song-index");
                    null == l && null == u && (t[a].innerHTML = e)
                }
            }

            function a(e) {
                for (var t = document.querySelectorAll('.amplitude-current-minutes[data-amplitude-playlist="' + u.default.active_playlist + '"]'), a = 0; a < t.length; a++) {
                    null == t[a].getAttribute("data-amplitude-song-index") && (t[a].innerHTML = e)
                }
            }

            function l(e) {
                if (null == u.default.active_playlist) for (var t = document.querySelectorAll('.amplitude-current-minutes[data-amplitude-song-index="' + u.default.active_index + '"]'), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist");
                    null == l && (t[a].innerHTML = e)
                }
            }

            function n(e) {
                for (var t = "" != u.default.active_playlist && null != u.default.active_playlist ? u.default.playlists[u.default.active_playlist].active_index : null, a = document.querySelectorAll('.amplitude-current-minutes[data-amplitude-playlist="' + u.default.active_playlist + '"][data-amplitude-song-index="' + t + '"]'), l = 0; l < a.length; l++) a[l].innerHTML = e
            }

            function i() {
                for (var e = document.querySelectorAll(".amplitude-current-minutes"), t = 0; t < e.length; t++) e[t].innerHTML = "00"
            }

            return {sync: e, resetTimes: i}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e(e) {
                t(e), a(e), l(e), n(e)
            }

            function t(e) {
                for (var t = document.querySelectorAll(".amplitude-current-seconds"), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist"),
                        u = t[a].getAttribute("data-amplitude-song-index");
                    null == l && null == u && (t[a].innerHTML = e)
                }
            }

            function a(e) {
                for (var t = document.querySelectorAll('.amplitude-current-seconds[data-amplitude-playlist="' + u.default.active_playlist + '"]'), a = 0; a < t.length; a++) {
                    null == t[a].getAttribute("data-amplitude-song-index") && (t[a].innerHTML = e)
                }
            }

            function l(e) {
                if (null == u.default.active_playlist) for (var t = document.querySelectorAll('.amplitude-current-seconds[data-amplitude-song-index="' + u.default.active_index + '"]'), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist");
                    null == l && (t[a].innerHTML = e)
                }
            }

            function n(e) {
                for (var t = "" != u.default.active_playlist && null != u.default.active_playlist ? u.default.playlists[u.default.active_playlist].active_index : null, a = document.querySelectorAll('.amplitude-current-seconds[data-amplitude-playlist="' + u.default.active_playlist + '"][data-amplitude-song-index="' + t + '"]'), l = 0; l < a.length; l++) a[l].innerHTML = e
            }

            function i() {
                for (var e = document.querySelectorAll(".amplitude-current-seconds"), t = 0; t < e.length; t++) e[t].innerHTML = "00"
            }

            return {sync: e, resetTimes: i}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e(e) {
                t(e), a(e), l(e), n(e)
            }

            function t(e) {
                var t = document.querySelectorAll(".amplitude-current-time"), a = e.minutes + ":" + e.seconds;
                e.hours > 0 && (a = e.hours + ":" + a);
                for (var l = 0; l < t.length; l++) {
                    var u = t[l].getAttribute("data-amplitude-playlist"),
                        n = t[l].getAttribute("data-amplitude-song-index");
                    null == u && null == n && (t[l].innerHTML = a)
                }
            }

            function a(e) {
                var t = document.querySelectorAll('.amplitude-current-time[data-amplitude-playlist="' + u.default.active_playlist + '"]'),
                    a = e.minutes + ":" + e.seconds;
                e.hours > 0 && (a = e.hours + ":" + a);
                for (var l = 0; l < t.length; l++) {
                    null == t[l].getAttribute("data-amplitude-song-index") && (t[l].innerHTML = a)
                }
            }

            function l(e) {
                if (null == u.default.active_playlist) {
                    var t = document.querySelectorAll('.amplitude-current-time[data-amplitude-song-index="' + u.default.active_index + '"]'),
                        a = e.minutes + ":" + e.seconds;
                    e.hours > 0 && (a = e.hours + ":" + a);
                    for (var l = 0; l < t.length; l++) {
                        null == t[l].getAttribute("data-amplitude-playlist") && (t[l].innerHTML = a)
                    }
                }
            }

            function n(e) {
                var t = "" != u.default.active_playlist && null != u.default.active_playlist ? u.default.playlists[u.default.active_playlist].active_index : null,
                    a = document.querySelectorAll('.amplitude-current-time[data-amplitude-playlist="' + u.default.active_playlist + '"][data-amplitude-song-index="' + t + '"]'),
                    l = e.minutes + ":" + e.seconds;
                e.hours > 0 && (l = e.hours + ":" + l);
                for (var n = 0; n < a.length; n++) a[n].innerHTML = l
            }

            function i() {
                for (var e = document.querySelectorAll(".amplitude-current-time"), t = 0; t < e.length; t++) e[t].innerHTML = "00:00"
            }

            return {sync: e, resetTimes: i}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e(e, u) {
                var i = d(e, u);
                t(i), a(i), l(i), n(i)
            }

            function t(e) {
                for (var t = document.querySelectorAll(".amplitude-time-remaining"), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist"),
                        u = t[a].getAttribute("data-amplitude-song-index");
                    null == l && null == u && (t[a].innerHTML = e)
                }
            }

            function a(e) {
                for (var t = document.querySelectorAll('.amplitude-time-remaining[data-amplitude-playlist="' + u.default.active_playlist + '"]'), a = 0; a < t.length; a++) {
                    null == t[a].getAttribute("data-amplitude-song-index") && (t[a].innerHTML = e)
                }
            }

            function l(e) {
                if (null == u.default.active_playlist) for (var t = document.querySelectorAll('.amplitude-time-remaining[data-amplitude-song-index="' + u.default.active_index + '"]'), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist");
                    null == l && (t[a].innerHTML = e)
                }
            }

            function n(e) {
                for (var t = "" != u.default.active_playlist && null != u.default.active_playlist ? u.default.playlists[u.default.active_playlist].active_index : null, a = document.querySelectorAll('.amplitude-time-remaining[data-amplitude-playlist="' + u.default.active_playlist + '"][data-amplitude-song-index="' + t + '"]'), l = 0; l < a.length; l++) a[l].innerHTML = e
            }

            function i() {
                for (var e = document.querySelectorAll(".amplitude-time-remaining"), t = 0; t < e.length; t++) e[t].innerHTML = "00"
            }

            function d(e, t) {
                var a = "00:00", l = parseInt(e.seconds) + 60 * parseInt(e.minutes) + 60 * parseInt(e.hours) * 60,
                    u = parseInt(t.seconds) + 60 * parseInt(t.minutes) + 60 * parseInt(t.hours) * 60;
                if (!isNaN(l) && !isNaN(u)) {
                    var n = u - l, i = Math.floor(n / 3600), d = Math.floor((n - 3600 * i) / 60),
                        s = n - 3600 * i - 60 * d;
                    a = (d < 10 ? "0" + d : d) + ":" + (s < 10 ? "0" + s : s), i > 0 && (a = i + ":" + a)
                }
                return a
            }

            return {sync: e, resetTimes: i}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e(e) {
                t(e), a(e), l(e), n(e)
            }

            function t(e) {
                for (var t = document.querySelectorAll(".amplitude-duration-hours"), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist"),
                        u = t[a].getAttribute("data-amplitude-song-index");
                    null == l && null == u && (t[a].innerHTML = e)
                }
            }

            function a(e) {
                for (var t = document.querySelectorAll('.amplitude-duration-hours[data-amplitude-playlist="' + u.default.active_playlist + '"]'), a = 0; a < t.length; a++) {
                    null == t[a].getAttribute("data-amplitude-song-index") && (t[a].innerHTML = e)
                }
            }

            function l(e) {
                if (null == u.default.active_playlist) for (var t = document.querySelectorAll('.amplitude-duration-hours[data-amplitude-song-index="' + u.default.active_index + '"]'), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist");
                    null == l && (t[a].innerHTML = e)
                }
            }

            function n(e) {
                for (var t = "" != u.default.active_playlist && null != u.default.active_playlist ? u.default.playlists[u.default.active_playlist].active_index : null, a = document.querySelectorAll('.amplitude-duration-hours[data-amplitude-playlist="' + u.default.active_playlist + '"][data-amplitude-song-index="' + t + '"]'), l = 0; l < a.length; l++) a[l].innerHTML = e
            }

            function i() {
                for (var e = document.querySelectorAll(".amplitude-duration-hours"), t = 0; t < e.length; t++) e[t].innerHTML = "00"
            }

            return {sync: e, resetTimes: i}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e(e) {
                t(e), a(e), l(e), n(e)
            }

            function t(e) {
                for (var t = document.querySelectorAll(".amplitude-duration-minutes"), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist"),
                        u = t[a].getAttribute("data-amplitude-song-index");
                    null == l && null == u && (t[a].innerHTML = e)
                }
            }

            function a(e) {
                for (var t = document.querySelectorAll('.amplitude-duration-minutes[data-amplitude-playlist="' + u.default.active_playlist + '"]'), a = 0; a < t.length; a++) {
                    null == t[a].getAttribute("data-amplitude-song-index") && (t[a].innerHTML = e)
                }
            }

            function l(e) {
                if (null == u.default.active_playlist) for (var t = document.querySelectorAll('.amplitude-duration-minutes[data-amplitude-song-index="' + u.default.active_index + '"]'), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist");
                    null == l && (t[a].innerHTML = e)
                }
            }

            function n(e) {
                for (var t = "" != u.default.active_playlist && null != u.default.active_playlist ? u.default.playlists[u.default.active_playlist].active_index : null, a = document.querySelectorAll('.amplitude-duration-minutes[data-amplitude-playlist="' + u.default.active_playlist + '"][data-amplitude-song-index="' + t + '"]'), l = 0; l < a.length; l++) a[l].innerHTML = e
            }

            function i() {
                for (var e = document.querySelectorAll(".amplitude-duration-minutes"), t = 0; t < e.length; t++) e[t].innerHTML = "00"
            }

            return {sync: e, resetTimes: i}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e(e) {
                t(e), a(e), l(e), n(e)
            }

            function t(e) {
                for (var t = document.querySelectorAll(".amplitude-duration-seconds"), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist"),
                        u = t[a].getAttribute("data-amplitude-song-index");
                    null == l && null == u && (t[a].innerHTML = e)
                }
            }

            function a(e) {
                for (var t = document.querySelectorAll('.amplitude-duration-seconds[data-amplitude-playlist="' + u.default.active_playlist + '"]'), a = 0; a < t.length; a++) {
                    null == t[a].getAttribute("data-amplitude-song-index") && (t[a].innerHTML = e)
                }
            }

            function l(e) {
                if (null == u.default.active_playlist) for (var t = document.querySelectorAll('.amplitude-duration-seconds[data-amplitude-song-index="' + u.default.active_index + '"]'), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data--amplitude-playlist");
                    null == l && (t[a].innerHTML = e)
                }
            }

            function n(e) {
                for (var t = "" != u.default.active_playlist && null != u.default.active_playlist ? u.default.playlists[u.default.active_playlist].active_index : null, a = document.querySelectorAll('.amplitude-duration-seconds[data-amplitude-playlist="' + u.default.active_playlist + '"][data-amplitude-song-index="' + t + '"]'), l = 0; l < a.length; l++) a[l].innerHTML = e
            }

            function i() {
                for (var e = document.querySelectorAll(".amplitude-duration-seconds"), t = 0; t < e.length; t++) e[t].innerHTML = "00"
            }

            return {sync: e, resetTimes: i}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t, a) {
        "use strict";
        Object.defineProperty(t, "__esModule", {value: !0});
        var l = a(0), u = function (e) {
            return e && e.__esModule ? e : {default: e}
        }(l), n = function () {
            function e(e) {
                var u = d(e);
                t(u), a(u), l(u), n(u)
            }

            function t(e) {
                for (var t = document.querySelectorAll(".amplitude-duration-time"), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist"),
                        u = t[a].getAttribute("data-amplitude-song-index");
                    null == l && null == u && (t[a].innerHTML = e)
                }
            }

            function a(e) {
                for (var t = document.querySelectorAll('.amplitude-duration-time[data-amplitude-playlist="' + u.default.active_playlist + '"]'), a = 0; a < t.length; a++) {
                    null == t[a].getAttribute("data-amplitude-song-index") && (t[a].innerHTML = e)
                }
            }

            function l(e) {
                if (null == u.default.active_playlist) for (var t = document.querySelectorAll('.amplitude-duration-time[data-amplitude-song-index="' + u.default.active_index + '"]'), a = 0; a < t.length; a++) {
                    var l = t[a].getAttribute("data-amplitude-playlist");
                    null == l && (t[a].innerHTML = e)
                }
            }

            function n(e) {
                for (var t = "" != u.default.active_playlist && null != u.default.active_playlist ? u.default.playlists[u.default.active_playlist].active_index : null, a = document.querySelectorAll('.amplitude-duration-time[data-amplitude-playlist="' + u.default.active_playlist + '"][data-amplitude-song-index="' + t + '"]'), l = 0; l < a.length; l++) a[l].innerHTML = e
            }

            function i() {
                for (var e = document.querySelectorAll(".amplitude-duration-time"), t = 0; t < e.length; t++) e[t].innerHTML = "00:00"
            }

            function d(e) {
                var t = "00:00";
                return isNaN(e.minutes) || isNaN(e.seconds) || (t = e.minutes + ":" + e.seconds, !isNaN(e.hours) && e.hours > 0 && (t = e.hours + ":" + t)), t
            }

            return {sync: e, resetTimes: i}
        }();
        t.default = n, e.exports = t.default
    }, function (e, t) {
        e.exports = {
            name: "amplitudejs",
            version: "5.3.2",
            description: "A JavaScript library that allows you to control the design of your media controls in your webpage -- not the browser. No dependencies (jQuery not required) https://521dimensions.com/open-source/amplitudejs",
            main: "dist/amplitude.js",
            devDependencies: {
                "babel-core": "^6.26.3",
                "babel-loader": "^7.1.5",
                "babel-plugin-add-module-exports": "0.2.1",
                "babel-polyfill": "^6.26.0",
                "babel-preset-es2015": "^6.18.0",
                husky: "^1.3.1",
                jest: "^23.6.0",
                prettier: "1.15.1",
                "pretty-quick": "^1.11.1",
                watch: "^1.0.2",
                webpack: "^2.7.0"
            },
            directories: {doc: "docs"},
            files: ["dist"],
            funding: {type: "opencollective", url: "https://opencollective.com/amplitudejs"},
            scripts: {
                build: "node_modules/.bin/webpack",
                prettier: "npx pretty-quick",
                preversion: "npx pretty-quick && npm run test",
                postversion: "git push && git push --tags",
                test: "jest",
                version: "npm run build && git add -A dist"
            },
            repository: {type: "git", url: "git+https://github.com/521dimensions/amplitudejs.git"},
            keywords: ["webaudio", "html5", "javascript", "audio-player"],
            author: "521 Dimensions (https://521dimensions.com)",
            license: "MIT",
            bugs: {url: "https://github.com/521dimensions/amplitudejs/issues"},
            homepage: "https://github.com/521dimensions/amplitudejs#readme"
        }
    }])
});

/*!
 * wavesurfer.js 4.0.1 (2020-06-24)
 * https://github.com/katspaugh/wavesurfer.js
 * @license BSD-3-Clause
 */
(function webpackUniversalModuleDefinition(root, factory) {
    if (typeof exports === 'object' && typeof module === 'object')
        module.exports = factory();
    else if (typeof define === 'function' && define.amd)
        define("WaveSurfer", [], factory);
    else if (typeof exports === 'object')
        exports["WaveSurfer"] = factory();
    else
        root["WaveSurfer"] = factory();
})(this, function () {
    return /******/ (function (modules) { // webpackBootstrap
        /******/ 	// The module cache
        /******/
        var installedModules = {};
        /******/
        /******/ 	// The require function
        /******/
        function __webpack_require__(moduleId) {
            /******/
            /******/ 		// Check if module is in cache
            /******/
            if (installedModules[moduleId]) {
                /******/
                return installedModules[moduleId].exports;
                /******/
            }
            /******/ 		// Create a new module (and put it into the cache)
            /******/
            var module = installedModules[moduleId] = {
                /******/            i: moduleId,
                /******/            l: false,
                /******/            exports: {}
                /******/
            };
            /******/
            /******/ 		// Execute the module function
            /******/
            modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
            /******/
            /******/ 		// Flag the module as loaded
            /******/
            module.l = true;
            /******/
            /******/ 		// Return the exports of the module
            /******/
            return module.exports;
            /******/
        }

        /******/
        /******/
        /******/ 	// expose the modules object (__webpack_modules__)
        /******/
        __webpack_require__.m = modules;
        /******/
        /******/ 	// expose the module cache
        /******/
        __webpack_require__.c = installedModules;
        /******/
        /******/ 	// define getter function for harmony exports
        /******/
        __webpack_require__.d = function (exports, name, getter) {
            /******/
            if (!__webpack_require__.o(exports, name)) {
                /******/
                Object.defineProperty(exports, name, {enumerable: true, get: getter});
                /******/
            }
            /******/
        };
        /******/
        /******/ 	// define __esModule on exports
        /******/
        __webpack_require__.r = function (exports) {
            /******/
            if (typeof Symbol !== 'undefined' && Symbol.toStringTag) {
                /******/
                Object.defineProperty(exports, Symbol.toStringTag, {value: 'Module'});
                /******/
            }
            /******/
            Object.defineProperty(exports, '__esModule', {value: true});
            /******/
        };
        /******/
        /******/ 	// create a fake namespace object
        /******/ 	// mode & 1: value is a module id, require it
        /******/ 	// mode & 2: merge all properties of value into the ns
        /******/ 	// mode & 4: return value when already ns object
        /******/ 	// mode & 8|1: behave like require
        /******/
        __webpack_require__.t = function (value, mode) {
            /******/
            if (mode & 1) value = __webpack_require__(value);
            /******/
            if (mode & 8) return value;
            /******/
            if ((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
            /******/
            var ns = Object.create(null);
            /******/
            __webpack_require__.r(ns);
            /******/
            Object.defineProperty(ns, 'default', {enumerable: true, value: value});
            /******/
            if (mode & 2 && typeof value != 'string') for (var key in value) __webpack_require__.d(ns, key, function (key) {
                return value[key];
            }.bind(null, key));
            /******/
            return ns;
            /******/
        };
        /******/
        /******/ 	// getDefaultExport function for compatibility with non-harmony modules
        /******/
        __webpack_require__.n = function (module) {
            /******/
            var getter = module && module.__esModule ?
                /******/            function getDefault() {
                    return module['default'];
                } :
                /******/            function getModuleExports() {
                    return module;
                };
            /******/
            __webpack_require__.d(getter, 'a', getter);
            /******/
            return getter;
            /******/
        };
        /******/
        /******/ 	// Object.prototype.hasOwnProperty.call
        /******/
        __webpack_require__.o = function (object, property) {
            return Object.prototype.hasOwnProperty.call(object, property);
        };
        /******/
        /******/ 	// __webpack_public_path__
        /******/
        __webpack_require__.p = "";
        /******/
        /******/
        /******/ 	// Load entry module and return exports
        /******/
        return __webpack_require__(__webpack_require__.s = "./src/wavesurfer.js");
        /******/
    })
        /************************************************************************/
        /******/ ({

            /***/ "./node_modules/debounce/index.js":
            /*!****************************************!*\
  !*** ./node_modules/debounce/index.js ***!
  \****************************************/
            /*! no static exports found */
            /***/ (function (module, exports) {

                /**
                 * Returns a function, that, as long as it continues to be invoked, will not
                 * be triggered. The function will be called after it stops being called for
                 * N milliseconds. If `immediate` is passed, trigger the function on the
                 * leading edge, instead of the trailing. The function also has a property 'clear'
                 * that is a function which will clear the timer to prevent previously scheduled executions.
                 *
                 * @source underscore.js
                 * @see http://unscriptable.com/2009/03/20/debouncing-javascript-methods/
                 * @param {Function} function to wrap
                 * @param {Number} timeout in ms (`100`)
                 * @param {Boolean} whether to execute at the beginning (`false`)
                 * @api public
                 */
                function debounce(func, wait, immediate) {
                    var timeout, args, context, timestamp, result;
                    if (null == wait) wait = 100;

                    function later() {
                        var last = Date.now() - timestamp;

                        if (last < wait && last >= 0) {
                            timeout = setTimeout(later, wait - last);
                        } else {
                            timeout = null;
                            if (!immediate) {
                                result = func.apply(context, args);
                                context = args = null;
                            }
                        }
                    };

                    var debounced = function () {
                        context = this;
                        args = arguments;
                        timestamp = Date.now();
                        var callNow = immediate && !timeout;
                        if (!timeout) timeout = setTimeout(later, wait);
                        if (callNow) {
                            result = func.apply(context, args);
                            context = args = null;
                        }

                        return result;
                    };

                    debounced.clear = function () {
                        if (timeout) {
                            clearTimeout(timeout);
                            timeout = null;
                        }
                    };

                    debounced.flush = function () {
                        if (timeout) {
                            result = func.apply(context, args);
                            context = args = null;

                            clearTimeout(timeout);
                            timeout = null;
                        }
                    };

                    return debounced;
                };

// Adds compatibility for ES modules
                debounce.debounce = debounce;

                module.exports = debounce;


                /***/
            }),

            /***/ "./src/drawer.canvasentry.js":
            /*!***********************************!*\
  !*** ./src/drawer.canvasentry.js ***!
  \***********************************/
            /*! no static exports found */
            /***/ (function (module, exports, __webpack_require__) {

                "use strict";


                Object.defineProperty(exports, "__esModule", {
                    value: true
                });
                exports.default = void 0;

                var _style = _interopRequireDefault(__webpack_require__(/*! ./util/style */ "./src/util/style.js"));

                var _getId = _interopRequireDefault(__webpack_require__(/*! ./util/get-id */ "./src/util/get-id.js"));

                function _interopRequireDefault(obj) {
                    return obj && obj.__esModule ? obj : {default: obj};
                }

                function _classCallCheck(instance, Constructor) {
                    if (!(instance instanceof Constructor)) {
                        throw new TypeError("Cannot call a class as a function");
                    }
                }

                function _defineProperties(target, props) {
                    for (var i = 0; i < props.length; i++) {
                        var descriptor = props[i];
                        descriptor.enumerable = descriptor.enumerable || false;
                        descriptor.configurable = true;
                        if ("value" in descriptor) descriptor.writable = true;
                        Object.defineProperty(target, descriptor.key, descriptor);
                    }
                }

                function _createClass(Constructor, protoProps, staticProps) {
                    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
                    if (staticProps) _defineProperties(Constructor, staticProps);
                    return Constructor;
                }

                /**
                 * The `CanvasEntry` class represents an element consisting of a wave `canvas`
                 * and an (optional) progress wave `canvas`.
                 *
                 * The `MultiCanvas` renderer uses one or more `CanvasEntry` instances to
                 * render a waveform, depending on the zoom level.
                 */
                var CanvasEntry =
                    /*#__PURE__*/
                    function () {
                        function CanvasEntry() {
                            _classCallCheck(this, CanvasEntry);

                            /**
                             * The wave node
                             *
                             * @type {HTMLCanvasElement}
                             */
                            this.wave = null;
                            /**
                             * The wave canvas rendering context
                             *
                             * @type {CanvasRenderingContext2D}
                             */

                            this.waveCtx = null;
                            /**
                             * The (optional) progress wave node
                             *
                             * @type {HTMLCanvasElement}
                             */

                            this.progress = null;
                            /**
                             * The (optional) progress wave canvas rendering context
                             *
                             * @type {CanvasRenderingContext2D}
                             */

                            this.progressCtx = null;
                            /**
                             * Start of the area the canvas should render, between 0 and 1
                             *
                             * @type {number}
                             */

                            this.start = 0;
                            /**
                             * End of the area the canvas should render, between 0 and 1
                             *
                             * @type {number}
                             */

                            this.end = 1;
                            /**
                             * Unique identifier for this entry
                             *
                             * @type {string}
                             */

                            this.id = (0, _getId.default)(typeof this.constructor.name !== 'undefined' ? this.constructor.name.toLowerCase() + '_' : 'canvasentry_');
                            /**
                             * Canvas 2d context attributes
                             *
                             * @type {object}
                             */

                            this.canvasContextAttributes = {};
                        }

                        /**
                         * Store the wave canvas element and create the 2D rendering context
                         *
                         * @param {HTMLCanvasElement} element The wave `canvas` element.
                         */


                        _createClass(CanvasEntry, [{
                            key: "initWave",
                            value: function initWave(element) {
                                this.wave = element;
                                this.waveCtx = this.wave.getContext('2d', this.canvasContextAttributes);
                            }
                            /**
                             * Store the progress wave canvas element and create the 2D rendering
                             * context
                             *
                             * @param {HTMLCanvasElement} element The progress wave `canvas` element.
                             */

                        }, {
                            key: "initProgress",
                            value: function initProgress(element) {
                                this.progress = element;
                                this.progressCtx = this.progress.getContext('2d', this.canvasContextAttributes);
                            }
                            /**
                             * Update the dimensions
                             *
                             * @param {number} elementWidth Width of the entry
                             * @param {number} totalWidth Total width of the multi canvas renderer
                             * @param {number} width The new width of the element
                             * @param {number} height The new height of the element
                             */

                        }, {
                            key: "updateDimensions",
                            value: function updateDimensions(elementWidth, totalWidth, width, height) {
                                // where the canvas starts and ends in the waveform, represented as a
                                // decimal between 0 and 1
                                this.start = this.wave.offsetLeft / totalWidth || 0;
                                this.end = this.start + elementWidth / totalWidth; // set wave canvas dimensions

                                this.wave.width = width;
                                this.wave.height = height;
                                var elementSize = {
                                    width: elementWidth + 'px'
                                };
                                (0, _style.default)(this.wave, elementSize);

                                if (this.hasProgressCanvas) {
                                    // set progress canvas dimensions
                                    this.progress.width = width;
                                    this.progress.height = height;
                                    (0, _style.default)(this.progress, elementSize);
                                }
                            }
                            /**
                             * Clear the wave and progress rendering contexts
                             */

                        }, {
                            key: "clearWave",
                            value: function clearWave() {
                                // wave
                                this.waveCtx.clearRect(0, 0, this.waveCtx.canvas.width, this.waveCtx.canvas.height); // progress

                                if (this.hasProgressCanvas) {
                                    this.progressCtx.clearRect(0, 0, this.progressCtx.canvas.width, this.progressCtx.canvas.height);
                                }
                            }
                            /**
                             * Set the fill styles for wave and progress
                             *
                             * @param {string} waveColor Fill color for the wave canvas
                             * @param {?string} progressColor Fill color for the progress canvas
                             */

                        }, {
                            key: "setFillStyles",
                            value: function setFillStyles(waveColor, progressColor) {
                                this.waveCtx.fillStyle = waveColor;

                                if (this.hasProgressCanvas) {
                                    this.progressCtx.fillStyle = progressColor;
                                }
                            }
                            /**
                             * Draw a rectangle for wave and progress
                             *
                             * @param {number} x X start position
                             * @param {number} y Y start position
                             * @param {number} width Width of the rectangle
                             * @param {number} height Height of the rectangle
                             * @param {number} radius Radius of the rectangle
                             */

                        }, {
                            key: "fillRects",
                            value: function fillRects(x, y, width, height, radius) {
                                this.fillRectToContext(this.waveCtx, x, y, width, height, radius);

                                if (this.hasProgressCanvas) {
                                    this.fillRectToContext(this.progressCtx, x, y, width, height, radius);
                                }
                            }
                            /**
                             * Draw the actual rectangle on a `canvas` element
                             *
                             * @param {CanvasRenderingContext2D} ctx Rendering context of target canvas
                             * @param {number} x X start position
                             * @param {number} y Y start position
                             * @param {number} width Width of the rectangle
                             * @param {number} height Height of the rectangle
                             * @param {number} radius Radius of the rectangle
                             */

                        }, {
                            key: "fillRectToContext",
                            value: function fillRectToContext(ctx, x, y, width, height, radius) {
                                if (!ctx) {
                                    return;
                                }

                                if (radius) {
                                    this.drawRoundedRect(ctx, x, y, width, height, radius);
                                } else {
                                    ctx.fillRect(x, y, width, height);
                                }
                            }
                            /**
                             * Draw a rounded rectangle on Canvas
                             *
                             * @param {CanvasRenderingContext2D} ctx Canvas context
                             * @param {number} x X-position of the rectangle
                             * @param {number} y Y-position of the rectangle
                             * @param {number} width Width of the rectangle
                             * @param {number} height Height of the rectangle
                             * @param {number} radius Radius of the rectangle
                             *
                             * @return {void}
                             * @example drawRoundedRect(ctx, 50, 50, 5, 10, 3)
                             */

                        }, {
                            key: "drawRoundedRect",
                            value: function drawRoundedRect(ctx, x, y, width, height, radius) {
                                if (height === 0) {
                                    return;
                                } // peaks are float values from -1 to 1. Use absolute height values in
                                // order to correctly calculate rounded rectangle coordinates


                                if (height < 0) {
                                    height *= -1;
                                    y -= height;
                                }

                                ctx.beginPath();
                                ctx.moveTo(x + radius, y);
                                ctx.lineTo(x + width - radius, y);
                                ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
                                ctx.lineTo(x + width, y + height - radius);
                                ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
                                ctx.lineTo(x + radius, y + height);
                                ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
                                ctx.lineTo(x, y + radius);
                                ctx.quadraticCurveTo(x, y, x + radius, y);
                                ctx.closePath();
                                ctx.fill();
                            }
                            /**
                             * Render the actual wave and progress lines
                             *
                             * @param {number[]} peaks Array with peaks data
                             * @param {number} absmax Maximum peak value (absolute)
                             * @param {number} halfH Half the height of the waveform
                             * @param {number} offsetY Offset to the top
                             * @param {number} start The x-offset of the beginning of the area that
                             * should be rendered
                             * @param {number} end The x-offset of the end of the area that
                             * should be rendered
                             */

                        }, {
                            key: "drawLines",
                            value: function drawLines(peaks, absmax, halfH, offsetY, start, end) {
                                this.drawLineToContext(this.waveCtx, peaks, absmax, halfH, offsetY, start, end);

                                if (this.hasProgressCanvas) {
                                    this.drawLineToContext(this.progressCtx, peaks, absmax, halfH, offsetY, start, end);
                                }
                            }
                            /**
                             * Render the actual waveform line on a `canvas` element
                             *
                             * @param {CanvasRenderingContext2D} ctx Rendering context of target canvas
                             * @param {number[]} peaks Array with peaks data
                             * @param {number} absmax Maximum peak value (absolute)
                             * @param {number} halfH Half the height of the waveform
                             * @param {number} offsetY Offset to the top
                             * @param {number} start The x-offset of the beginning of the area that
                             * should be rendered
                             * @param {number} end The x-offset of the end of the area that
                             * should be rendered
                             */

                        }, {
                            key: "drawLineToContext",
                            value: function drawLineToContext(ctx, peaks, absmax, halfH, offsetY, start, end) {
                                if (!ctx) {
                                    return;
                                }

                                var length = peaks.length / 2;
                                var first = Math.round(length * this.start); // use one more peak value to make sure we join peaks at ends -- unless,
                                // of course, this is the last canvas

                                var last = Math.round(length * this.end) + 1;
                                var canvasStart = first;
                                var canvasEnd = last;
                                var scale = this.wave.width / (canvasEnd - canvasStart - 1); // optimization

                                var halfOffset = halfH + offsetY;
                                var absmaxHalf = absmax / halfH;
                                ctx.beginPath();
                                ctx.moveTo((canvasStart - first) * scale, halfOffset);
                                ctx.lineTo((canvasStart - first) * scale, halfOffset - Math.round((peaks[2 * canvasStart] || 0) / absmaxHalf));
                                var i, peak, h;

                                for (i = canvasStart; i < canvasEnd; i++) {
                                    peak = peaks[2 * i] || 0;
                                    h = Math.round(peak / absmaxHalf);
                                    ctx.lineTo((i - first) * scale + this.halfPixel, halfOffset - h);
                                } // draw the bottom edge going backwards, to make a single
                                // closed hull to fill


                                var j = canvasEnd - 1;

                                for (j; j >= canvasStart; j--) {
                                    peak = peaks[2 * j + 1] || 0;
                                    h = Math.round(peak / absmaxHalf);
                                    ctx.lineTo((j - first) * scale + this.halfPixel, halfOffset - h);
                                }

                                ctx.lineTo((canvasStart - first) * scale, halfOffset - Math.round((peaks[2 * canvasStart + 1] || 0) / absmaxHalf));
                                ctx.closePath();
                                ctx.fill();
                            }
                            /**
                             * Destroys this entry
                             */

                        }, {
                            key: "destroy",
                            value: function destroy() {
                                this.waveCtx = null;
                                this.wave = null;
                                this.progressCtx = null;
                                this.progress = null;
                            }
                            /**
                             * Return image data of the wave `canvas` element
                             *
                             * When using a `type` of `'blob'`, this will return a `Promise` that
                             * resolves with a `Blob` instance.
                             *
                             * @param {string} format='image/png' An optional value of a format type.
                             * @param {number} quality=0.92 An optional value between 0 and 1.
                             * @param {string} type='dataURL' Either 'dataURL' or 'blob'.
                             * @return {string|Promise} When using the default `'dataURL'` `type` this
                             * returns a data URL. When using the `'blob'` `type` this returns a
                             * `Promise` that resolves with a `Blob` instance.
                             */

                        }, {
                            key: "getImage",
                            value: function getImage(format, quality, type) {
                                var _this = this;

                                if (type === 'blob') {
                                    return new Promise(function (resolve) {
                                        _this.wave.toBlob(resolve, format, quality);
                                    });
                                } else if (type === 'dataURL') {
                                    return this.wave.toDataURL(format, quality);
                                }
                            }
                        }]);

                        return CanvasEntry;
                    }();

                exports.default = CanvasEntry;
                module.exports = exports.default;

                /***/
            }),

            /***/ "./src/drawer.js":
            /*!***********************!*\
  !*** ./src/drawer.js ***!
  \***********************/
            /*! no static exports found */
            /***/ (function (module, exports, __webpack_require__) {

                "use strict";


                Object.defineProperty(exports, "__esModule", {
                    value: true
                });
                exports.default = void 0;

                var util = _interopRequireWildcard(__webpack_require__(/*! ./util */ "./src/util/index.js"));

                function _getRequireWildcardCache() {
                    if (typeof WeakMap !== "function") return null;
                    var cache = new WeakMap();
                    _getRequireWildcardCache = function _getRequireWildcardCache() {
                        return cache;
                    };
                    return cache;
                }

                function _interopRequireWildcard(obj) {
                    if (obj && obj.__esModule) {
                        return obj;
                    }
                    if (obj === null || _typeof(obj) !== "object" && typeof obj !== "function") {
                        return {default: obj};
                    }
                    var cache = _getRequireWildcardCache();
                    if (cache && cache.has(obj)) {
                        return cache.get(obj);
                    }
                    var newObj = {};
                    var hasPropertyDescriptor = Object.defineProperty && Object.getOwnPropertyDescriptor;
                    for (var key in obj) {
                        if (Object.prototype.hasOwnProperty.call(obj, key)) {
                            var desc = hasPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : null;
                            if (desc && (desc.get || desc.set)) {
                                Object.defineProperty(newObj, key, desc);
                            } else {
                                newObj[key] = obj[key];
                            }
                        }
                    }
                    newObj.default = obj;
                    if (cache) {
                        cache.set(obj, newObj);
                    }
                    return newObj;
                }

                function _typeof(obj) {
                    if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
                        _typeof = function _typeof(obj) {
                            return typeof obj;
                        };
                    } else {
                        _typeof = function _typeof(obj) {
                            return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
                        };
                    }
                    return _typeof(obj);
                }

                function _classCallCheck(instance, Constructor) {
                    if (!(instance instanceof Constructor)) {
                        throw new TypeError("Cannot call a class as a function");
                    }
                }

                function _defineProperties(target, props) {
                    for (var i = 0; i < props.length; i++) {
                        var descriptor = props[i];
                        descriptor.enumerable = descriptor.enumerable || false;
                        descriptor.configurable = true;
                        if ("value" in descriptor) descriptor.writable = true;
                        Object.defineProperty(target, descriptor.key, descriptor);
                    }
                }

                function _createClass(Constructor, protoProps, staticProps) {
                    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
                    if (staticProps) _defineProperties(Constructor, staticProps);
                    return Constructor;
                }

                function _possibleConstructorReturn(self, call) {
                    if (call && (_typeof(call) === "object" || typeof call === "function")) {
                        return call;
                    }
                    return _assertThisInitialized(self);
                }

                function _assertThisInitialized(self) {
                    if (self === void 0) {
                        throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                    }
                    return self;
                }

                function _getPrototypeOf(o) {
                    _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
                        return o.__proto__ || Object.getPrototypeOf(o);
                    };
                    return _getPrototypeOf(o);
                }

                function _inherits(subClass, superClass) {
                    if (typeof superClass !== "function" && superClass !== null) {
                        throw new TypeError("Super expression must either be null or a function");
                    }
                    subClass.prototype = Object.create(superClass && superClass.prototype, {
                        constructor: {
                            value: subClass,
                            writable: true,
                            configurable: true
                        }
                    });
                    if (superClass) _setPrototypeOf(subClass, superClass);
                }

                function _setPrototypeOf(o, p) {
                    _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
                        o.__proto__ = p;
                        return o;
                    };
                    return _setPrototypeOf(o, p);
                }

                /**
                 * Parent class for renderers
                 *
                 * @extends {Observer}
                 */
                var Drawer =
                    /*#__PURE__*/
                    function (_util$Observer) {
                        _inherits(Drawer, _util$Observer);

                        /**
                         * @param {HTMLElement} container The container node of the wavesurfer instance
                         * @param {WavesurferParams} params The wavesurfer initialisation options
                         */
                        function Drawer(container, params) {
                            var _this;

                            _classCallCheck(this, Drawer);

                            _this = _possibleConstructorReturn(this, _getPrototypeOf(Drawer).call(this));
                            _this.container = container;
                            /**
                             * @type {WavesurferParams}
                             */

                            _this.params = params;
                            /**
                             * The width of the renderer
                             * @type {number}
                             */

                            _this.width = 0;
                            /**
                             * The height of the renderer
                             * @type {number}
                             */

                            _this.height = params.height * _this.params.pixelRatio;
                            _this.lastPos = 0;
                            /**
                             * The `<wave>` element which is added to the container
                             * @type {HTMLElement}
                             */

                            _this.wrapper = null;
                            return _this;
                        }

                        /**
                         * Alias of `util.style`
                         *
                         * @param {HTMLElement} el The element that the styles will be applied to
                         * @param {Object} styles The map of propName: attribute, both are used as-is
                         * @return {HTMLElement} el
                         */


                        _createClass(Drawer, [{
                            key: "style",
                            value: function style(el, styles) {
                                return util.style(el, styles);
                            }
                            /**
                             * Create the wrapper `<wave>` element, style it and set up the events for
                             * interaction
                             */

                        }, {
                            key: "createWrapper",
                            value: function createWrapper() {
                                this.wrapper = this.container.appendChild(document.createElement('wave'));
                                this.style(this.wrapper, {
                                    display: 'block',
                                    position: 'relative',
                                    userSelect: 'none',
                                    webkitUserSelect: 'none',
                                    height: this.params.height + 'px'
                                });

                                if (this.params.fillParent || this.params.scrollParent) {
                                    this.style(this.wrapper, {
                                        width: '100%',
                                        overflowX: this.params.hideScrollbar ? 'hidden' : 'auto',
                                        overflowY: 'hidden'
                                    });
                                }

                                this.setupWrapperEvents();
                            }
                            /**
                             * Handle click event
                             *
                             * @param {Event} e Click event
                             * @param {?boolean} noPrevent Set to true to not call `e.preventDefault()`
                             * @return {number} Playback position from 0 to 1
                             */

                        }, {
                            key: "handleEvent",
                            value: function handleEvent(e, noPrevent) {
                                !noPrevent && e.preventDefault();
                                var clientX = e.targetTouches ? e.targetTouches[0].clientX : e.clientX;
                                var bbox = this.wrapper.getBoundingClientRect();
                                var nominalWidth = this.width;
                                var parentWidth = this.getWidth();
                                var progress;

                                if (!this.params.fillParent && nominalWidth < parentWidth) {
                                    progress = (this.params.rtl ? bbox.right - clientX : clientX - bbox.left) * (this.params.pixelRatio / nominalWidth) || 0;

                                    if (progress > 1) {
                                        progress = 1;
                                    }
                                } else {
                                    progress = ((this.params.rtl ? bbox.right - clientX : clientX - bbox.left) + this.wrapper.scrollLeft) / this.wrapper.scrollWidth || 0;
                                }

                                return progress;
                            }
                        }, {
                            key: "setupWrapperEvents",
                            value: function setupWrapperEvents() {
                                var _this2 = this;

                                this.wrapper.addEventListener('click', function (e) {
                                    var scrollbarHeight = _this2.wrapper.offsetHeight - _this2.wrapper.clientHeight;

                                    if (scrollbarHeight !== 0) {
                                        // scrollbar is visible.  Check if click was on it
                                        var bbox = _this2.wrapper.getBoundingClientRect();

                                        if (e.clientY >= bbox.bottom - scrollbarHeight) {
                                            // ignore mousedown as it was on the scrollbar
                                            return;
                                        }
                                    }

                                    if (_this2.params.interact) {
                                        _this2.fireEvent('click', e, _this2.handleEvent(e));
                                    }
                                });
                                this.wrapper.addEventListener('dblclick', function (e) {
                                    if (_this2.params.interact) {
                                        _this2.fireEvent('dblclick', e, _this2.handleEvent(e));
                                    }
                                });
                                this.wrapper.addEventListener('scroll', function (e) {
                                    return _this2.fireEvent('scroll', e);
                                });
                            }
                            /**
                             * Draw peaks on the canvas
                             *
                             * @param {number[]|Number.<Array[]>} peaks Can also be an array of arrays
                             * for split channel rendering
                             * @param {number} length The width of the area that should be drawn
                             * @param {number} start The x-offset of the beginning of the area that
                             * should be rendered
                             * @param {number} end The x-offset of the end of the area that should be
                             * rendered
                             */

                        }, {
                            key: "drawPeaks",
                            value: function drawPeaks(peaks, length, start, end) {
                                if (!this.setWidth(length)) {
                                    this.clearWave();
                                }

                                this.params.barWidth ? this.drawBars(peaks, 0, start, end) : this.drawWave(peaks, 0, start, end);
                            }
                            /**
                             * Scroll to the beginning
                             */

                        }, {
                            key: "resetScroll",
                            value: function resetScroll() {
                                if (this.wrapper !== null) {
                                    this.wrapper.scrollLeft = 0;
                                }
                            }
                            /**
                             * Recenter the view-port at a certain percent of the waveform
                             *
                             * @param {number} percent Value from 0 to 1 on the waveform
                             */

                        }, {
                            key: "recenter",
                            value: function recenter(percent) {
                                var position = this.wrapper.scrollWidth * percent;
                                this.recenterOnPosition(position, true);
                            }
                            /**
                             * Recenter the view-port on a position, either scroll there immediately or
                             * in steps of 5 pixels
                             *
                             * @param {number} position X-offset in pixels
                             * @param {boolean} immediate Set to true to immediately scroll somewhere
                             */

                        }, {
                            key: "recenterOnPosition",
                            value: function recenterOnPosition(position, immediate) {
                                var scrollLeft = this.wrapper.scrollLeft;
                                var half = ~~(this.wrapper.clientWidth / 2);
                                var maxScroll = this.wrapper.scrollWidth - this.wrapper.clientWidth;
                                var target = position - half;
                                var offset = target - scrollLeft;

                                if (maxScroll == 0) {
                                    // no need to continue if scrollbar is not there
                                    return;
                                } // if the cursor is currently visible...


                                if (!immediate && -half <= offset && offset < half) {
                                    // set rate at which waveform is centered
                                    var rate = this.params.autoCenterRate; // make rate depend on width of view and length of waveform

                                    rate /= half;
                                    rate *= maxScroll;
                                    offset = Math.max(-rate, Math.min(rate, offset));
                                    target = scrollLeft + offset;
                                } // limit target to valid range (0 to maxScroll)


                                target = Math.max(0, Math.min(maxScroll, target)); // no use attempting to scroll if we're not moving

                                if (target != scrollLeft) {
                                    this.wrapper.scrollLeft = target;
                                }
                            }
                            /**
                             * Get the current scroll position in pixels
                             *
                             * @return {number} Horizontal scroll position in pixels
                             */

                        }, {
                            key: "getScrollX",
                            value: function getScrollX() {
                                var x = 0;

                                if (this.wrapper) {
                                    var pixelRatio = this.params.pixelRatio;
                                    x = Math.round(this.wrapper.scrollLeft * pixelRatio); // In cases of elastic scroll (safari with mouse wheel) you can
                                    // scroll beyond the limits of the container
                                    // Calculate and floor the scrollable extent to make sure an out
                                    // of bounds value is not returned
                                    // Ticket #1312

                                    if (this.params.scrollParent) {
                                        var maxScroll = ~~(this.wrapper.scrollWidth * pixelRatio - this.getWidth());
                                        x = Math.min(maxScroll, Math.max(0, x));
                                    }
                                }

                                return x;
                            }
                            /**
                             * Get the width of the container
                             *
                             * @return {number} The width of the container
                             */

                        }, {
                            key: "getWidth",
                            value: function getWidth() {
                                return Math.round(this.container.clientWidth * this.params.pixelRatio);
                            }
                            /**
                             * Set the width of the container
                             *
                             * @param {number} width The new width of the container
                             * @return {boolean} Whether the width of the container was updated or not
                             */

                        }, {
                            key: "setWidth",
                            value: function setWidth(width) {
                                if (this.width == width) {
                                    return false;
                                }

                                this.width = width;

                                if (this.params.fillParent || this.params.scrollParent) {
                                    this.style(this.wrapper, {
                                        width: ''
                                    });
                                } else {
                                    this.style(this.wrapper, {
                                        width: ~~(this.width / this.params.pixelRatio) + 'px'
                                    });
                                }

                                this.updateSize();
                                return true;
                            }
                            /**
                             * Set the height of the container
                             *
                             * @param {number} height The new height of the container.
                             * @return {boolean} Whether the height of the container was updated or not
                             */

                        }, {
                            key: "setHeight",
                            value: function setHeight(height) {
                                if (height == this.height) {
                                    return false;
                                }

                                this.height = height;
                                this.style(this.wrapper, {
                                    height: ~~(this.height / this.params.pixelRatio) + 'px'
                                });
                                this.updateSize();
                                return true;
                            }
                            /**
                             * Called by wavesurfer when progress should be rendered
                             *
                             * @param {number} progress From 0 to 1
                             */

                        }, {
                            key: "progress",
                            value: function progress(_progress) {
                                var minPxDelta = 1 / this.params.pixelRatio;
                                var pos = Math.round(_progress * this.width) * minPxDelta;

                                if (pos < this.lastPos || pos - this.lastPos >= minPxDelta) {
                                    this.lastPos = pos;

                                    if (this.params.scrollParent && this.params.autoCenter) {
                                        var newPos = ~~(this.wrapper.scrollWidth * _progress);
                                        this.recenterOnPosition(newPos, this.params.autoCenterImmediately);
                                    }

                                    this.updateProgress(pos);
                                }
                            }
                            /**
                             * This is called when wavesurfer is destroyed
                             */

                        }, {
                            key: "destroy",
                            value: function destroy() {
                                this.unAll();

                                if (this.wrapper) {
                                    if (this.wrapper.parentNode == this.container) {
                                        this.container.removeChild(this.wrapper);
                                    }

                                    this.wrapper = null;
                                }
                            }
                            /* Renderer-specific methods */

                            /**
                             * Called after cursor related params have changed.
                             *
                             * @abstract
                             */

                        }, {
                            key: "updateCursor",
                            value: function updateCursor() {
                            }
                            /**
                             * Called when the size of the container changes so the renderer can adjust
                             *
                             * @abstract
                             */

                        }, {
                            key: "updateSize",
                            value: function updateSize() {
                            }
                            /**
                             * Draw a waveform with bars
                             *
                             * @abstract
                             * @param {number[]|Number.<Array[]>} peaks Can also be an array of arrays for split channel
                             * rendering
                             * @param {number} channelIndex The index of the current channel. Normally
                             * should be 0
                             * @param {number} start The x-offset of the beginning of the area that
                             * should be rendered
                             * @param {number} end The x-offset of the end of the area that should be
                             * rendered
                             */

                        }, {
                            key: "drawBars",
                            value: function drawBars(peaks, channelIndex, start, end) {
                            }
                            /**
                             * Draw a waveform
                             *
                             * @abstract
                             * @param {number[]|Number.<Array[]>} peaks Can also be an array of arrays for split channel
                             * rendering
                             * @param {number} channelIndex The index of the current channel. Normally
                             * should be 0
                             * @param {number} start The x-offset of the beginning of the area that
                             * should be rendered
                             * @param {number} end The x-offset of the end of the area that should be
                             * rendered
                             */

                        }, {
                            key: "drawWave",
                            value: function drawWave(peaks, channelIndex, start, end) {
                            }
                            /**
                             * Clear the waveform
                             *
                             * @abstract
                             */

                        }, {
                            key: "clearWave",
                            value: function clearWave() {
                            }
                            /**
                             * Render the new progress
                             *
                             * @abstract
                             * @param {number} position X-Offset of progress position in pixels
                             */

                        }, {
                            key: "updateProgress",
                            value: function updateProgress(position) {
                            }
                        }]);

                        return Drawer;
                    }(util.Observer);

                exports.default = Drawer;
                module.exports = exports.default;

                /***/
            }),

            /***/ "./src/drawer.multicanvas.js":
            /*!***********************************!*\
  !*** ./src/drawer.multicanvas.js ***!
  \***********************************/
            /*! no static exports found */
            /***/ (function (module, exports, __webpack_require__) {

                "use strict";


                Object.defineProperty(exports, "__esModule", {
                    value: true
                });
                exports.default = void 0;

                var _drawer = _interopRequireDefault(__webpack_require__(/*! ./drawer */ "./src/drawer.js"));

                var util = _interopRequireWildcard(__webpack_require__(/*! ./util */ "./src/util/index.js"));

                var _drawer2 = _interopRequireDefault(__webpack_require__(/*! ./drawer.canvasentry */ "./src/drawer.canvasentry.js"));

                function _getRequireWildcardCache() {
                    if (typeof WeakMap !== "function") return null;
                    var cache = new WeakMap();
                    _getRequireWildcardCache = function _getRequireWildcardCache() {
                        return cache;
                    };
                    return cache;
                }

                function _interopRequireWildcard(obj) {
                    if (obj && obj.__esModule) {
                        return obj;
                    }
                    if (obj === null || _typeof(obj) !== "object" && typeof obj !== "function") {
                        return {default: obj};
                    }
                    var cache = _getRequireWildcardCache();
                    if (cache && cache.has(obj)) {
                        return cache.get(obj);
                    }
                    var newObj = {};
                    var hasPropertyDescriptor = Object.defineProperty && Object.getOwnPropertyDescriptor;
                    for (var key in obj) {
                        if (Object.prototype.hasOwnProperty.call(obj, key)) {
                            var desc = hasPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : null;
                            if (desc && (desc.get || desc.set)) {
                                Object.defineProperty(newObj, key, desc);
                            } else {
                                newObj[key] = obj[key];
                            }
                        }
                    }
                    newObj.default = obj;
                    if (cache) {
                        cache.set(obj, newObj);
                    }
                    return newObj;
                }

                function _interopRequireDefault(obj) {
                    return obj && obj.__esModule ? obj : {default: obj};
                }

                function _typeof(obj) {
                    if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
                        _typeof = function _typeof(obj) {
                            return typeof obj;
                        };
                    } else {
                        _typeof = function _typeof(obj) {
                            return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
                        };
                    }
                    return _typeof(obj);
                }

                function _classCallCheck(instance, Constructor) {
                    if (!(instance instanceof Constructor)) {
                        throw new TypeError("Cannot call a class as a function");
                    }
                }

                function _defineProperties(target, props) {
                    for (var i = 0; i < props.length; i++) {
                        var descriptor = props[i];
                        descriptor.enumerable = descriptor.enumerable || false;
                        descriptor.configurable = true;
                        if ("value" in descriptor) descriptor.writable = true;
                        Object.defineProperty(target, descriptor.key, descriptor);
                    }
                }

                function _createClass(Constructor, protoProps, staticProps) {
                    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
                    if (staticProps) _defineProperties(Constructor, staticProps);
                    return Constructor;
                }

                function _possibleConstructorReturn(self, call) {
                    if (call && (_typeof(call) === "object" || typeof call === "function")) {
                        return call;
                    }
                    return _assertThisInitialized(self);
                }

                function _assertThisInitialized(self) {
                    if (self === void 0) {
                        throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                    }
                    return self;
                }

                function _getPrototypeOf(o) {
                    _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
                        return o.__proto__ || Object.getPrototypeOf(o);
                    };
                    return _getPrototypeOf(o);
                }

                function _inherits(subClass, superClass) {
                    if (typeof superClass !== "function" && superClass !== null) {
                        throw new TypeError("Super expression must either be null or a function");
                    }
                    subClass.prototype = Object.create(superClass && superClass.prototype, {
                        constructor: {
                            value: subClass,
                            writable: true,
                            configurable: true
                        }
                    });
                    if (superClass) _setPrototypeOf(subClass, superClass);
                }

                function _setPrototypeOf(o, p) {
                    _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
                        o.__proto__ = p;
                        return o;
                    };
                    return _setPrototypeOf(o, p);
                }

                /**
                 * MultiCanvas renderer for wavesurfer. Is currently the default and sole
                 * builtin renderer.
                 *
                 * A `MultiCanvas` consists of one or more `CanvasEntry` instances, depending
                 * on the zoom level.
                 */
                var MultiCanvas =
                    /*#__PURE__*/
                    function (_Drawer) {
                        _inherits(MultiCanvas, _Drawer);

                        /**
                         * @param {HTMLElement} container The container node of the wavesurfer instance
                         * @param {WavesurferParams} params The wavesurfer initialisation options
                         */
                        function MultiCanvas(container, params) {
                            var _this;

                            _classCallCheck(this, MultiCanvas);

                            _this = _possibleConstructorReturn(this, _getPrototypeOf(MultiCanvas).call(this, container, params));
                            /**
                             * @type {number}
                             */

                            _this.maxCanvasWidth = params.maxCanvasWidth;
                            /**
                             * @type {number}
                             */

                            _this.maxCanvasElementWidth = Math.round(params.maxCanvasWidth / params.pixelRatio);
                            /**
                             * Whether or not the progress wave is rendered. If the `waveColor`
                             * and `progressColor` are the same color it is not.
                             *
                             * @type {boolean}
                             */

                            _this.hasProgressCanvas = params.waveColor != params.progressColor;
                            /**
                             * @type {number}
                             */

                            _this.halfPixel = 0.5 / params.pixelRatio;
                            /**
                             * List of `CanvasEntry` instances.
                             *
                             * @type {Array}
                             */

                            _this.canvases = [];
                            /**
                             * @type {HTMLElement}
                             */

                            _this.progressWave = null;
                            /**
                             * Class used to generate entries.
                             *
                             * @type {function}
                             */

                            _this.EntryClass = _drawer2.default;
                            /**
                             * Canvas 2d context attributes.
                             *
                             * @type {object}
                             */

                            _this.canvasContextAttributes = params.drawingContextAttributes;
                            /**
                             * Overlap added between entries to prevent vertical white stripes
                             * between `canvas` elements.
                             *
                             * @type {number}
                             */

                            _this.overlap = 2 * Math.ceil(params.pixelRatio / 2);
                            /**
                             * The radius of the wave bars. Makes bars rounded
                             *
                             * @type {number}
                             */

                            _this.barRadius = params.barRadius || 0;
                            return _this;
                        }

                        /**
                         * Initialize the drawer
                         */


                        _createClass(MultiCanvas, [{
                            key: "init",
                            value: function init() {
                                this.createWrapper();
                                this.createElements();
                            }
                            /**
                             * Create the canvas elements and style them
                             *
                             */

                        }, {
                            key: "createElements",
                            value: function createElements() {
                                this.progressWave = this.wrapper.appendChild(this.style(document.createElement('wave'), {
                                    position: 'absolute',
                                    zIndex: 3,
                                    left: 0,
                                    top: 0,
                                    bottom: 0,
                                    overflow: 'hidden',
                                    width: '0',
                                    display: 'none',
                                    boxSizing: 'border-box',
                                    borderRightStyle: 'solid',
                                    pointerEvents: 'none'
                                }));
                                this.addCanvas();
                                this.updateCursor();
                            }
                            /**
                             * Update cursor style
                             */

                        }, {
                            key: "updateCursor",
                            value: function updateCursor() {
                                this.style(this.progressWave, {
                                    borderRightWidth: this.params.cursorWidth + 'px',
                                    borderRightColor: this.params.cursorColor
                                });
                            }
                            /**
                             * Adjust to the updated size by adding or removing canvases
                             */

                        }, {
                            key: "updateSize",
                            value: function updateSize() {
                                var _this2 = this;

                                var totalWidth = Math.round(this.width / this.params.pixelRatio);
                                var requiredCanvases = Math.ceil(totalWidth / (this.maxCanvasElementWidth + this.overlap)); // add required canvases

                                while (this.canvases.length < requiredCanvases) {
                                    this.addCanvas();
                                } // remove older existing canvases, if any


                                while (this.canvases.length > requiredCanvases) {
                                    this.removeCanvas();
                                }

                                var canvasWidth = this.maxCanvasWidth + this.overlap;
                                var lastCanvas = this.canvases.length - 1;
                                this.canvases.forEach(function (entry, i) {
                                    if (i == lastCanvas) {
                                        canvasWidth = _this2.width - _this2.maxCanvasWidth * lastCanvas;
                                    }

                                    _this2.updateDimensions(entry, canvasWidth, _this2.height);

                                    entry.clearWave();
                                });
                            }
                            /**
                             * Add a canvas to the canvas list
                             *
                             */

                        }, {
                            key: "addCanvas",
                            value: function addCanvas() {
                                var entry = new this.EntryClass();
                                entry.canvasContextAttributes = this.canvasContextAttributes;
                                entry.hasProgressCanvas = this.hasProgressCanvas;
                                entry.halfPixel = this.halfPixel;
                                var leftOffset = this.maxCanvasElementWidth * this.canvases.length; // wave

                                entry.initWave(this.wrapper.appendChild(this.style(document.createElement('canvas'), {
                                    position: 'absolute',
                                    zIndex: 2,
                                    left: leftOffset + 'px',
                                    top: 0,
                                    bottom: 0,
                                    height: '100%',
                                    pointerEvents: 'none'
                                }))); // progress

                                if (this.hasProgressCanvas) {
                                    entry.initProgress(this.progressWave.appendChild(this.style(document.createElement('canvas'), {
                                        position: 'absolute',
                                        left: leftOffset + 'px',
                                        top: 0,
                                        bottom: 0,
                                        height: '100%'
                                    })));
                                }

                                this.canvases.push(entry);
                            }
                            /**
                             * Pop single canvas from the list
                             *
                             */

                        }, {
                            key: "removeCanvas",
                            value: function removeCanvas() {
                                var lastEntry = this.canvases[this.canvases.length - 1]; // wave

                                lastEntry.wave.parentElement.removeChild(lastEntry.wave); // progress

                                if (this.hasProgressCanvas) {
                                    lastEntry.progress.parentElement.removeChild(lastEntry.progress);
                                } // cleanup


                                if (lastEntry) {
                                    lastEntry.destroy();
                                    lastEntry = null;
                                }

                                this.canvases.pop();
                            }
                            /**
                             * Update the dimensions of a canvas element
                             *
                             * @param {CanvasEntry} entry Target entry
                             * @param {number} width The new width of the element
                             * @param {number} height The new height of the element
                             */

                        }, {
                            key: "updateDimensions",
                            value: function updateDimensions(entry, width, height) {
                                var elementWidth = Math.round(width / this.params.pixelRatio);
                                var totalWidth = Math.round(this.width / this.params.pixelRatio); // update canvas dimensions

                                entry.updateDimensions(elementWidth, totalWidth, width, height); // style element

                                this.style(this.progressWave, {
                                    display: 'block'
                                });
                            }
                            /**
                             * Clear the whole multi-canvas
                             */

                        }, {
                            key: "clearWave",
                            value: function clearWave() {
                                var _this3 = this;

                                util.frame(function () {
                                    _this3.canvases.forEach(function (entry) {
                                        return entry.clearWave();
                                    });
                                })();
                            }
                            /**
                             * Draw a waveform with bars
                             *
                             * @param {number[]|Number.<Array[]>} peaks Can also be an array of arrays
                             * for split channel rendering
                             * @param {number} channelIndex The index of the current channel. Normally
                             * should be 0. Must be an integer.
                             * @param {number} start The x-offset of the beginning of the area that
                             * should be rendered
                             * @param {number} end The x-offset of the end of the area that should be
                             * rendered
                             * @returns {void}
                             */

                        }, {
                            key: "drawBars",
                            value: function drawBars(peaks, channelIndex, start, end) {
                                var _this4 = this;

                                return this.prepareDraw(peaks, channelIndex, start, end, function (_ref) {
                                    var absmax = _ref.absmax,
                                        hasMinVals = _ref.hasMinVals,
                                        height = _ref.height,
                                        offsetY = _ref.offsetY,
                                        halfH = _ref.halfH,
                                        peaks = _ref.peaks;

                                    // if drawBars was called within ws.empty we don't pass a start and
                                    // don't want anything to happen
                                    if (start === undefined) {
                                        return;
                                    } // Skip every other value if there are negatives.


                                    var peakIndexScale = hasMinVals ? 2 : 1;
                                    var length = peaks.length / peakIndexScale;
                                    var bar = _this4.params.barWidth * _this4.params.pixelRatio;
                                    var gap = _this4.params.barGap === null ? Math.max(_this4.params.pixelRatio, ~~(bar / 2)) : Math.max(_this4.params.pixelRatio, _this4.params.barGap * _this4.params.pixelRatio);
                                    var step = bar + gap;
                                    var scale = length / _this4.width;
                                    var first = start;
                                    var last = end;
                                    var i = first;

                                    for (i; i < last; i += step) {
                                        var peak = peaks[Math.floor(i * scale * peakIndexScale)] || 0;
                                        var h = Math.round(peak / absmax * halfH);
                                        /* in case of silences, allow the user to specify that we
           * always draw *something* (normally a 1px high bar) */

                                        if (h == 0 && _this4.params.barMinHeight) h = _this4.params.barMinHeight;

                                        _this4.fillRect(i + _this4.halfPixel, halfH - h + offsetY, bar + _this4.halfPixel, h * 2, _this4.barRadius);
                                    }
                                });
                            }
                            /**
                             * Draw a waveform
                             *
                             * @param {number[]|Number.<Array[]>} peaks Can also be an array of arrays
                             * for split channel rendering
                             * @param {number} channelIndex The index of the current channel. Normally
                             * should be 0
                             * @param {number?} start The x-offset of the beginning of the area that
                             * should be rendered (If this isn't set only a flat line is rendered)
                             * @param {number?} end The x-offset of the end of the area that should be
                             * rendered
                             * @returns {void}
                             */

                        }, {
                            key: "drawWave",
                            value: function drawWave(peaks, channelIndex, start, end) {
                                var _this5 = this;

                                return this.prepareDraw(peaks, channelIndex, start, end, function (_ref2) {
                                    var absmax = _ref2.absmax,
                                        hasMinVals = _ref2.hasMinVals,
                                        height = _ref2.height,
                                        offsetY = _ref2.offsetY,
                                        halfH = _ref2.halfH,
                                        peaks = _ref2.peaks,
                                        channelIndex = _ref2.channelIndex;

                                    if (!hasMinVals) {
                                        var reflectedPeaks = [];
                                        var len = peaks.length;
                                        var i = 0;

                                        for (i; i < len; i++) {
                                            reflectedPeaks[2 * i] = peaks[i];
                                            reflectedPeaks[2 * i + 1] = -peaks[i];
                                        }

                                        peaks = reflectedPeaks;
                                    } // if drawWave was called within ws.empty we don't pass a start and
                                    // end and simply want a flat line


                                    if (start !== undefined) {
                                        _this5.drawLine(peaks, absmax, halfH, offsetY, start, end, channelIndex);
                                    } // always draw a median line


                                    _this5.fillRect(0, halfH + offsetY - _this5.halfPixel, _this5.width, _this5.halfPixel, _this5.barRadius);
                                });
                            }
                            /**
                             * Tell the canvas entries to render their portion of the waveform
                             *
                             * @param {number[]} peaks Peaks data
                             * @param {number} absmax Maximum peak value (absolute)
                             * @param {number} halfH Half the height of the waveform
                             * @param {number} offsetY Offset to the top
                             * @param {number} start The x-offset of the beginning of the area that
                             * should be rendered
                             * @param {number} end The x-offset of the end of the area that
                             * should be rendered
                             * @param {channelIndex} channelIndex The channel index of the line drawn
                             */

                        }, {
                            key: "drawLine",
                            value: function drawLine(peaks, absmax, halfH, offsetY, start, end, channelIndex) {
                                var _this6 = this;

                                var _ref3 = this.params.splitChannelsOptions.channelColors[channelIndex] || {},
                                    waveColor = _ref3.waveColor,
                                    progressColor = _ref3.progressColor;

                                this.canvases.forEach(function (entry, i) {
                                    _this6.setFillStyles(entry, waveColor, progressColor);

                                    entry.drawLines(peaks, absmax, halfH, offsetY, start, end);
                                });
                            }
                            /**
                             * Draw a rectangle on the multi-canvas
                             *
                             * @param {number} x X-position of the rectangle
                             * @param {number} y Y-position of the rectangle
                             * @param {number} width Width of the rectangle
                             * @param {number} height Height of the rectangle
                             * @param {number} radius Radius of the rectangle
                             */

                        }, {
                            key: "fillRect",
                            value: function fillRect(x, y, width, height, radius) {
                                var startCanvas = Math.floor(x / this.maxCanvasWidth);
                                var endCanvas = Math.min(Math.ceil((x + width) / this.maxCanvasWidth) + 1, this.canvases.length);
                                var i = startCanvas;

                                for (i; i < endCanvas; i++) {
                                    var entry = this.canvases[i];
                                    var leftOffset = i * this.maxCanvasWidth;
                                    var intersection = {
                                        x1: Math.max(x, i * this.maxCanvasWidth),
                                        y1: y,
                                        x2: Math.min(x + width, i * this.maxCanvasWidth + entry.wave.width),
                                        y2: y + height
                                    };

                                    if (intersection.x1 < intersection.x2) {
                                        this.setFillStyles(entry);
                                        entry.fillRects(intersection.x1 - leftOffset, intersection.y1, intersection.x2 - intersection.x1, intersection.y2 - intersection.y1, radius);
                                    }
                                }
                            }
                            /**
                             * Returns whether to hide the channel from being drawn based on params.
                             *
                             * @param {number} channelIndex The index of the current channel.
                             * @returns {bool} True to hide the channel, false to draw.
                             */

                        }, {
                            key: "hideChannel",
                            value: function hideChannel(channelIndex) {
                                return this.params.splitChannels && this.params.splitChannelsOptions.filterChannels.includes(channelIndex);
                            }
                            /**
                             * Performs preparation tasks and calculations which are shared by `drawBars`
                             * and `drawWave`
                             *
                             * @param {number[]|Number.<Array[]>} peaks Can also be an array of arrays for
                             * split channel rendering
                             * @param {number} channelIndex The index of the current channel. Normally
                             * should be 0
                             * @param {number?} start The x-offset of the beginning of the area that
                             * should be rendered. If this isn't set only a flat line is rendered
                             * @param {number?} end The x-offset of the end of the area that should be
                             * rendered
                             * @param {function} fn The render function to call, e.g. `drawWave`
                             * @param {number} drawIndex The index of the current channel after filtering.
                             * @returns {void}
                             */

                        }, {
                            key: "prepareDraw",
                            value: function prepareDraw(peaks, channelIndex, start, end, fn, drawIndex) {
                                var _this7 = this;

                                return util.frame(function () {
                                    // Split channels and call this function with the channelIndex set
                                    if (peaks[0] instanceof Array) {
                                        var channels = peaks;

                                        if (_this7.params.splitChannels) {
                                            var filteredChannels = channels.filter(function (c, i) {
                                                return !_this7.hideChannel(i);
                                            });

                                            if (!_this7.params.splitChannelsOptions.overlay) {
                                                _this7.setHeight(Math.max(filteredChannels.length, 1) * _this7.params.height * _this7.params.pixelRatio);
                                            }

                                            return channels.forEach(function (channelPeaks, i) {
                                                return _this7.prepareDraw(channelPeaks, i, start, end, fn, filteredChannels.indexOf(channelPeaks));
                                            });
                                        }

                                        peaks = channels[0];
                                    } // Return and do not draw channel peaks if hidden.


                                    if (_this7.hideChannel(channelIndex)) {
                                        return;
                                    } // calculate maximum modulation value, either from the barHeight
                                    // parameter or if normalize=true from the largest value in the peak
                                    // set


                                    var absmax = 1 / _this7.params.barHeight;

                                    if (_this7.params.normalize) {
                                        var max = util.max(peaks);
                                        var min = util.min(peaks);
                                        absmax = -min > max ? -min : max;
                                    } // Bar wave draws the bottom only as a reflection of the top,
                                    // so we don't need negative values


                                    var hasMinVals = [].some.call(peaks, function (val) {
                                        return val < 0;
                                    });
                                    var height = _this7.params.height * _this7.params.pixelRatio;
                                    var offsetY = height * drawIndex || 0;
                                    var halfH = height / 2;
                                    return fn({
                                        absmax: absmax,
                                        hasMinVals: hasMinVals,
                                        height: height,
                                        offsetY: offsetY,
                                        halfH: halfH,
                                        peaks: peaks,
                                        channelIndex: channelIndex
                                    });
                                })();
                            }
                            /**
                             * Set the fill styles for a certain entry (wave and progress)
                             *
                             * @param {CanvasEntry} entry Target entry
                             * @param {string} waveColor Wave color to draw this entry
                             * @param {string} progressColor Progress color to draw this entry
                             */

                        }, {
                            key: "setFillStyles",
                            value: function setFillStyles(entry) {
                                var waveColor = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : this.params.waveColor;
                                var progressColor = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : this.params.progressColor;
                                entry.setFillStyles(waveColor, progressColor);
                            }
                            /**
                             * Return image data of the multi-canvas
                             *
                             * When using a `type` of `'blob'`, this will return a `Promise`.
                             *
                             * @param {string} format='image/png' An optional value of a format type.
                             * @param {number} quality=0.92 An optional value between 0 and 1.
                             * @param {string} type='dataURL' Either 'dataURL' or 'blob'.
                             * @return {string|string[]|Promise} When using the default `'dataURL'`
                             * `type` this returns a single data URL or an array of data URLs,
                             * one for each canvas. When using the `'blob'` `type` this returns a
                             * `Promise` that resolves with an array of `Blob` instances, one for each
                             * canvas.
                             */

                        }, {
                            key: "getImage",
                            value: function getImage(format, quality, type) {
                                if (type === 'blob') {
                                    return Promise.all(this.canvases.map(function (entry) {
                                        return entry.getImage(format, quality, type);
                                    }));
                                } else if (type === 'dataURL') {
                                    var images = this.canvases.map(function (entry) {
                                        return entry.getImage(format, quality, type);
                                    });
                                    return images.length > 1 ? images : images[0];
                                }
                            }
                            /**
                             * Render the new progress
                             *
                             * @param {number} position X-offset of progress position in pixels
                             */

                        }, {
                            key: "updateProgress",
                            value: function updateProgress(position) {
                                this.style(this.progressWave, {
                                    width: position + 'px'
                                });
                            }
                        }]);

                        return MultiCanvas;
                    }(_drawer.default);

                exports.default = MultiCanvas;
                module.exports = exports.default;

                /***/
            }),

            /***/ "./src/mediaelement-webaudio.js":
            /*!**************************************!*\
  !*** ./src/mediaelement-webaudio.js ***!
  \**************************************/
            /*! no static exports found */
            /***/ (function (module, exports, __webpack_require__) {

                "use strict";


                Object.defineProperty(exports, "__esModule", {
                    value: true
                });
                exports.default = void 0;

                var _mediaelement = _interopRequireDefault(__webpack_require__(/*! ./mediaelement */ "./src/mediaelement.js"));

                function _interopRequireDefault(obj) {
                    return obj && obj.__esModule ? obj : {default: obj};
                }

                function _typeof(obj) {
                    if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
                        _typeof = function _typeof(obj) {
                            return typeof obj;
                        };
                    } else {
                        _typeof = function _typeof(obj) {
                            return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
                        };
                    }
                    return _typeof(obj);
                }

                function _classCallCheck(instance, Constructor) {
                    if (!(instance instanceof Constructor)) {
                        throw new TypeError("Cannot call a class as a function");
                    }
                }

                function _defineProperties(target, props) {
                    for (var i = 0; i < props.length; i++) {
                        var descriptor = props[i];
                        descriptor.enumerable = descriptor.enumerable || false;
                        descriptor.configurable = true;
                        if ("value" in descriptor) descriptor.writable = true;
                        Object.defineProperty(target, descriptor.key, descriptor);
                    }
                }

                function _createClass(Constructor, protoProps, staticProps) {
                    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
                    if (staticProps) _defineProperties(Constructor, staticProps);
                    return Constructor;
                }

                function _possibleConstructorReturn(self, call) {
                    if (call && (_typeof(call) === "object" || typeof call === "function")) {
                        return call;
                    }
                    return _assertThisInitialized(self);
                }

                function _assertThisInitialized(self) {
                    if (self === void 0) {
                        throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                    }
                    return self;
                }

                function _get(target, property, receiver) {
                    if (typeof Reflect !== "undefined" && Reflect.get) {
                        _get = Reflect.get;
                    } else {
                        _get = function _get(target, property, receiver) {
                            var base = _superPropBase(target, property);
                            if (!base) return;
                            var desc = Object.getOwnPropertyDescriptor(base, property);
                            if (desc.get) {
                                return desc.get.call(receiver);
                            }
                            return desc.value;
                        };
                    }
                    return _get(target, property, receiver || target);
                }

                function _superPropBase(object, property) {
                    while (!Object.prototype.hasOwnProperty.call(object, property)) {
                        object = _getPrototypeOf(object);
                        if (object === null) break;
                    }
                    return object;
                }

                function _getPrototypeOf(o) {
                    _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
                        return o.__proto__ || Object.getPrototypeOf(o);
                    };
                    return _getPrototypeOf(o);
                }

                function _inherits(subClass, superClass) {
                    if (typeof superClass !== "function" && superClass !== null) {
                        throw new TypeError("Super expression must either be null or a function");
                    }
                    subClass.prototype = Object.create(superClass && superClass.prototype, {
                        constructor: {
                            value: subClass,
                            writable: true,
                            configurable: true
                        }
                    });
                    if (superClass) _setPrototypeOf(subClass, superClass);
                }

                function _setPrototypeOf(o, p) {
                    _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
                        o.__proto__ = p;
                        return o;
                    };
                    return _setPrototypeOf(o, p);
                }

                /**
                 * MediaElementWebAudio backend: load audio via an HTML5 audio tag, but playback with the WebAudio API.
                 * The advantage here is that the html5 <audio> tag can perform range requests on the server and not
                 * buffer the entire file in one request, and you still get the filtering and scripting functionality
                 * of the webaudio API.
                 * Note that in order to use range requests and prevent buffering, you must provide peak data.
                 *
                 * @since 3.2.0
                 */
                var MediaElementWebAudio =
                    /*#__PURE__*/
                    function (_MediaElement) {
                        _inherits(MediaElementWebAudio, _MediaElement);

                        /**
                         * Construct the backend
                         *
                         * @param {WavesurferParams} params Wavesurfer parameters
                         */
                        function MediaElementWebAudio(params) {
                            var _this;

                            _classCallCheck(this, MediaElementWebAudio);

                            _this = _possibleConstructorReturn(this, _getPrototypeOf(MediaElementWebAudio).call(this, params));
                            /** @private */

                            _this.params = params;
                            /** @private */

                            _this.sourceMediaElement = null;
                            return _this;
                        }

                        /**
                         * Initialise the backend, called in `wavesurfer.createBackend()`
                         */


                        _createClass(MediaElementWebAudio, [{
                            key: "init",
                            value: function init() {
                                this.setPlaybackRate(this.params.audioRate);
                                this.createTimer();
                                this.createVolumeNode();
                                this.createScriptNode();
                                this.createAnalyserNode();
                            }
                            /**
                             * Private method called by both `load` (from url)
                             * and `loadElt` (existing media element) methods.
                             *
                             * @param {HTMLMediaElement} media HTML5 Audio or Video element
                             * @param {number[]|Number.<Array[]>} peaks Array of peak data
                             * @private
                             */

                        }, {
                            key: "_load",
                            value: function _load(media, peaks) {
                                _get(_getPrototypeOf(MediaElementWebAudio.prototype), "_load", this).call(this, media, peaks);

                                this.createMediaElementSource(media);
                            }
                            /**
                             * Create MediaElementSource node
                             *
                             * @since 3.2.0
                             * @param {HTMLMediaElement} mediaElement HTML5 Audio to load
                             */

                        }, {
                            key: "createMediaElementSource",
                            value: function createMediaElementSource(mediaElement) {
                                this.sourceMediaElement = this.ac.createMediaElementSource(mediaElement);
                                this.sourceMediaElement.connect(this.analyser);
                            }
                        }, {
                            key: "play",
                            value: function play(start, end) {
                                this.resumeAudioContext();
                                return _get(_getPrototypeOf(MediaElementWebAudio.prototype), "play", this).call(this, start, end);
                            }
                            /**
                             * This is called when wavesurfer is destroyed
                             *
                             */

                        }, {
                            key: "destroy",
                            value: function destroy() {
                                _get(_getPrototypeOf(MediaElementWebAudio.prototype), "destroy", this).call(this);

                                this.destroyWebAudio();
                            }
                        }]);

                        return MediaElementWebAudio;
                    }(_mediaelement.default);

                exports.default = MediaElementWebAudio;
                module.exports = exports.default;

                /***/
            }),

            /***/ "./src/mediaelement.js":
            /*!*****************************!*\
  !*** ./src/mediaelement.js ***!
  \*****************************/
            /*! no static exports found */
            /***/ (function (module, exports, __webpack_require__) {

                "use strict";


                Object.defineProperty(exports, "__esModule", {
                    value: true
                });
                exports.default = void 0;

                var _webaudio = _interopRequireDefault(__webpack_require__(/*! ./webaudio */ "./src/webaudio.js"));

                var util = _interopRequireWildcard(__webpack_require__(/*! ./util */ "./src/util/index.js"));

                function _getRequireWildcardCache() {
                    if (typeof WeakMap !== "function") return null;
                    var cache = new WeakMap();
                    _getRequireWildcardCache = function _getRequireWildcardCache() {
                        return cache;
                    };
                    return cache;
                }

                function _interopRequireWildcard(obj) {
                    if (obj && obj.__esModule) {
                        return obj;
                    }
                    if (obj === null || _typeof(obj) !== "object" && typeof obj !== "function") {
                        return {default: obj};
                    }
                    var cache = _getRequireWildcardCache();
                    if (cache && cache.has(obj)) {
                        return cache.get(obj);
                    }
                    var newObj = {};
                    var hasPropertyDescriptor = Object.defineProperty && Object.getOwnPropertyDescriptor;
                    for (var key in obj) {
                        if (Object.prototype.hasOwnProperty.call(obj, key)) {
                            var desc = hasPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : null;
                            if (desc && (desc.get || desc.set)) {
                                Object.defineProperty(newObj, key, desc);
                            } else {
                                newObj[key] = obj[key];
                            }
                        }
                    }
                    newObj.default = obj;
                    if (cache) {
                        cache.set(obj, newObj);
                    }
                    return newObj;
                }

                function _interopRequireDefault(obj) {
                    return obj && obj.__esModule ? obj : {default: obj};
                }

                function _typeof(obj) {
                    if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
                        _typeof = function _typeof(obj) {
                            return typeof obj;
                        };
                    } else {
                        _typeof = function _typeof(obj) {
                            return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
                        };
                    }
                    return _typeof(obj);
                }

                function _classCallCheck(instance, Constructor) {
                    if (!(instance instanceof Constructor)) {
                        throw new TypeError("Cannot call a class as a function");
                    }
                }

                function _defineProperties(target, props) {
                    for (var i = 0; i < props.length; i++) {
                        var descriptor = props[i];
                        descriptor.enumerable = descriptor.enumerable || false;
                        descriptor.configurable = true;
                        if ("value" in descriptor) descriptor.writable = true;
                        Object.defineProperty(target, descriptor.key, descriptor);
                    }
                }

                function _createClass(Constructor, protoProps, staticProps) {
                    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
                    if (staticProps) _defineProperties(Constructor, staticProps);
                    return Constructor;
                }

                function _possibleConstructorReturn(self, call) {
                    if (call && (_typeof(call) === "object" || typeof call === "function")) {
                        return call;
                    }
                    return _assertThisInitialized(self);
                }

                function _assertThisInitialized(self) {
                    if (self === void 0) {
                        throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                    }
                    return self;
                }

                function _get(target, property, receiver) {
                    if (typeof Reflect !== "undefined" && Reflect.get) {
                        _get = Reflect.get;
                    } else {
                        _get = function _get(target, property, receiver) {
                            var base = _superPropBase(target, property);
                            if (!base) return;
                            var desc = Object.getOwnPropertyDescriptor(base, property);
                            if (desc.get) {
                                return desc.get.call(receiver);
                            }
                            return desc.value;
                        };
                    }
                    return _get(target, property, receiver || target);
                }

                function _superPropBase(object, property) {
                    while (!Object.prototype.hasOwnProperty.call(object, property)) {
                        object = _getPrototypeOf(object);
                        if (object === null) break;
                    }
                    return object;
                }

                function _getPrototypeOf(o) {
                    _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
                        return o.__proto__ || Object.getPrototypeOf(o);
                    };
                    return _getPrototypeOf(o);
                }

                function _inherits(subClass, superClass) {
                    if (typeof superClass !== "function" && superClass !== null) {
                        throw new TypeError("Super expression must either be null or a function");
                    }
                    subClass.prototype = Object.create(superClass && superClass.prototype, {
                        constructor: {
                            value: subClass,
                            writable: true,
                            configurable: true
                        }
                    });
                    if (superClass) _setPrototypeOf(subClass, superClass);
                }

                function _setPrototypeOf(o, p) {
                    _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
                        o.__proto__ = p;
                        return o;
                    };
                    return _setPrototypeOf(o, p);
                }

                /**
                 * MediaElement backend
                 */
                var MediaElement =
                    /*#__PURE__*/
                    function (_WebAudio) {
                        _inherits(MediaElement, _WebAudio);

                        /**
                         * Construct the backend
                         *
                         * @param {WavesurferParams} params Wavesurfer parameters
                         */
                        function MediaElement(params) {
                            var _this;

                            _classCallCheck(this, MediaElement);

                            _this = _possibleConstructorReturn(this, _getPrototypeOf(MediaElement).call(this, params));
                            /** @private */

                            _this.params = params;
                            /**
                             * Initially a dummy media element to catch errors. Once `_load` is
                             * called, this will contain the actual `HTMLMediaElement`.
                             * @private
                             */

                            _this.media = {
                                currentTime: 0,
                                duration: 0,
                                paused: true,
                                playbackRate: 1,
                                play: function play() {
                                },
                                pause: function pause() {
                                },
                                volume: 0
                            };
                            /** @private */

                            _this.mediaType = params.mediaType.toLowerCase();
                            /** @private */

                            _this.elementPosition = params.elementPosition;
                            /** @private */

                            _this.peaks = null;
                            /** @private */

                            _this.playbackRate = 1;
                            /** @private */

                            _this.volume = 1;
                            /** @private */

                            _this.isMuted = false;
                            /** @private */

                            _this.buffer = null;
                            /** @private */

                            _this.onPlayEnd = null;
                            /** @private */

                            _this.mediaListeners = {};
                            return _this;
                        }

                        /**
                         * Initialise the backend, called in `wavesurfer.createBackend()`
                         */


                        _createClass(MediaElement, [{
                            key: "init",
                            value: function init() {
                                this.setPlaybackRate(this.params.audioRate);
                                this.createTimer();
                            }
                            /**
                             * Attach event listeners to media element.
                             */

                        }, {
                            key: "_setupMediaListeners",
                            value: function _setupMediaListeners() {
                                var _this2 = this;

                                this.mediaListeners.error = function () {
                                    _this2.fireEvent('error', 'Error loading media element');
                                };

                                this.mediaListeners.canplay = function () {
                                    _this2.fireEvent('canplay');
                                };

                                this.mediaListeners.ended = function () {
                                    _this2.fireEvent('finish');
                                }; // listen to and relay play, pause and seeked events to enable
                                // playback control from the external media element


                                this.mediaListeners.play = function () {
                                    _this2.fireEvent('play');
                                };

                                this.mediaListeners.pause = function () {
                                    _this2.fireEvent('pause');
                                };

                                this.mediaListeners.seeked = function (event) {
                                    _this2.fireEvent('seek');
                                };

                                this.mediaListeners.volumechange = function (event) {
                                    _this2.isMuted = _this2.media.muted;

                                    if (_this2.isMuted) {
                                        _this2.volume = 0;
                                    } else {
                                        _this2.volume = _this2.media.volume;
                                    }

                                    _this2.fireEvent('volume');
                                }; // reset event listeners


                                Object.keys(this.mediaListeners).forEach(function (id) {
                                    _this2.media.removeEventListener(id, _this2.mediaListeners[id]);

                                    _this2.media.addEventListener(id, _this2.mediaListeners[id]);
                                });
                            }
                            /**
                             * Create a timer to provide a more precise `audioprocess` event.
                             */

                        }, {
                            key: "createTimer",
                            value: function createTimer() {
                                var _this3 = this;

                                var onAudioProcess = function onAudioProcess() {
                                    if (_this3.isPaused()) {
                                        return;
                                    }

                                    _this3.fireEvent('audioprocess', _this3.getCurrentTime()); // Call again in the next frame


                                    util.frame(onAudioProcess)();
                                };

                                this.on('play', onAudioProcess); // Update the progress one more time to prevent it from being stuck in
                                // case of lower framerates

                                this.on('pause', function () {
                                    _this3.fireEvent('audioprocess', _this3.getCurrentTime());
                                });
                            }
                            /**
                             * Create media element with url as its source,
                             * and append to container element.
                             *
                             * @param {string} url Path to media file
                             * @param {HTMLElement} container HTML element
                             * @param {number[]|Number.<Array[]>} peaks Array of peak data
                             * @param {string} preload HTML 5 preload attribute value
                             * @throws Will throw an error if the `url` argument is not a valid media
                             * element.
                             */

                        }, {
                            key: "load",
                            value: function load(url, container, peaks, preload) {
                                var media = document.createElement(this.mediaType);
                                media.controls = this.params.mediaControls;
                                media.autoplay = this.params.autoplay || false;
                                media.preload = preload == null ? 'auto' : preload;
                                media.src = url;
                                media.style.width = '100%';
                                var prevMedia = container.querySelector(this.mediaType);

                                if (prevMedia) {
                                    container.removeChild(prevMedia);
                                }

                                container.appendChild(media);

                                this._load(media, peaks);
                            }
                            /**
                             * Load existing media element.
                             *
                             * @param {HTMLMediaElement} elt HTML5 Audio or Video element
                             * @param {number[]|Number.<Array[]>} peaks Array of peak data
                             */

                        }, {
                            key: "loadElt",
                            value: function loadElt(elt, peaks) {
                                elt.controls = this.params.mediaControls;
                                elt.autoplay = this.params.autoplay || false;

                                this._load(elt, peaks);
                            }
                            /**
                             * Method called by both `load` (from url)
                             * and `loadElt` (existing media element) methods.
                             *
                             * @param {HTMLMediaElement} media HTML5 Audio or Video element
                             * @param {number[]|Number.<Array[]>} peaks Array of peak data
                             * @throws Will throw an error if the `media` argument is not a valid media
                             * element.
                             * @private
                             */

                        }, {
                            key: "_load",
                            value: function _load(media, peaks) {
                                // verify media element is valid
                                if (!(media instanceof HTMLMediaElement) || typeof media.addEventListener === 'undefined') {
                                    throw new Error('media parameter is not a valid media element');
                                } // load must be called manually on iOS, otherwise peaks won't draw
                                // until a user interaction triggers load --> 'ready' event


                                if (typeof media.load == 'function') {
                                    // Resets the media element and restarts the media resource. Any
                                    // pending events are discarded. How much media data is fetched is
                                    // still affected by the preload attribute.
                                    media.load();
                                }

                                this.media = media;

                                this._setupMediaListeners();

                                this.peaks = peaks;
                                this.onPlayEnd = null;
                                this.buffer = null;
                                this.isMuted = media.muted;
                                this.setPlaybackRate(this.playbackRate);
                                this.setVolume(this.volume);
                            }
                            /**
                             * Used by `wavesurfer.isPlaying()` and `wavesurfer.playPause()`
                             *
                             * @return {boolean} Media paused or not
                             */

                        }, {
                            key: "isPaused",
                            value: function isPaused() {
                                return !this.media || this.media.paused;
                            }
                            /**
                             * Used by `wavesurfer.getDuration()`
                             *
                             * @return {number} Duration
                             */

                        }, {
                            key: "getDuration",
                            value: function getDuration() {
                                if (this.explicitDuration) {
                                    return this.explicitDuration;
                                }

                                var duration = (this.buffer || this.media).duration;

                                if (duration >= Infinity) {
                                    // streaming audio
                                    duration = this.media.seekable.end(0);
                                }

                                return duration;
                            }
                            /**
                             * Returns the current time in seconds relative to the audio-clip's
                             * duration.
                             *
                             * @return {number} Current time
                             */

                        }, {
                            key: "getCurrentTime",
                            value: function getCurrentTime() {
                                return this.media && this.media.currentTime;
                            }
                            /**
                             * Get the position from 0 to 1
                             *
                             * @return {number} Current position
                             */

                        }, {
                            key: "getPlayedPercents",
                            value: function getPlayedPercents() {
                                return this.getCurrentTime() / this.getDuration() || 0;
                            }
                            /**
                             * Get the audio source playback rate.
                             *
                             * @return {number} Playback rate
                             */

                        }, {
                            key: "getPlaybackRate",
                            value: function getPlaybackRate() {
                                return this.playbackRate || this.media.playbackRate;
                            }
                            /**
                             * Set the audio source playback rate.
                             *
                             * @param {number} value Playback rate
                             */

                        }, {
                            key: "setPlaybackRate",
                            value: function setPlaybackRate(value) {
                                this.playbackRate = value || 1;
                                this.media.playbackRate = this.playbackRate;
                            }
                            /**
                             * Used by `wavesurfer.seekTo()`
                             *
                             * @param {number} start Position to start at in seconds
                             */

                        }, {
                            key: "seekTo",
                            value: function seekTo(start) {
                                if (start != null) {
                                    this.media.currentTime = start;
                                }

                                this.clearPlayEnd();
                            }
                            /**
                             * Plays the loaded audio region.
                             *
                             * @param {number} start Start offset in seconds, relative to the beginning
                             * of a clip.
                             * @param {number} end When to stop, relative to the beginning of a clip.
                             * @emits MediaElement#play
                             * @return {Promise} Result
                             */

                        }, {
                            key: "play",
                            value: function play(start, end) {
                                this.seekTo(start);
                                var promise = this.media.play();
                                end && this.setPlayEnd(end);
                                return promise;
                            }
                            /**
                             * Pauses the loaded audio.
                             *
                             * @emits MediaElement#pause
                             * @return {Promise} Result
                             */

                        }, {
                            key: "pause",
                            value: function pause() {
                                var promise;

                                if (this.media) {
                                    promise = this.media.pause();
                                }

                                this.clearPlayEnd();
                                return promise;
                            }
                            /**
                             * Set the play end
                             *
                             * @param {number} end Where to end
                             */

                        }, {
                            key: "setPlayEnd",
                            value: function setPlayEnd(end) {
                                var _this4 = this;

                                this.clearPlayEnd();

                                this._onPlayEnd = function (time) {
                                    if (time >= end) {
                                        _this4.pause();

                                        _this4.seekTo(end);
                                    }
                                };

                                this.on('audioprocess', this._onPlayEnd);
                            }
                            /** @private */

                        }, {
                            key: "clearPlayEnd",
                            value: function clearPlayEnd() {
                                if (this._onPlayEnd) {
                                    this.un('audioprocess', this._onPlayEnd);
                                    this._onPlayEnd = null;
                                }
                            }
                            /**
                             * Compute the max and min value of the waveform when broken into
                             * <length> subranges.
                             *
                             * @param {number} length How many subranges to break the waveform into.
                             * @param {number} first First sample in the required range.
                             * @param {number} last Last sample in the required range.
                             * @return {number[]|Number.<Array[]>} Array of 2*<length> peaks or array of
                             * arrays of peaks consisting of (max, min) values for each subrange.
                             */

                        }, {
                            key: "getPeaks",
                            value: function getPeaks(length, first, last) {
                                if (this.buffer) {
                                    return _get(_getPrototypeOf(MediaElement.prototype), "getPeaks", this).call(this, length, first, last);
                                }

                                return this.peaks || [];
                            }
                            /**
                             * Set the sink id for the media player
                             *
                             * @param {string} deviceId String value representing audio device id.
                             * @returns {Promise} A Promise that resolves to `undefined` when there
                             * are no errors.
                             */

                        }, {
                            key: "setSinkId",
                            value: function setSinkId(deviceId) {
                                if (deviceId) {
                                    if (!this.media.setSinkId) {
                                        return Promise.reject(new Error('setSinkId is not supported in your browser'));
                                    }

                                    return this.media.setSinkId(deviceId);
                                }

                                return Promise.reject(new Error('Invalid deviceId: ' + deviceId));
                            }
                            /**
                             * Get the current volume
                             *
                             * @return {number} value A floating point value between 0 and 1.
                             */

                        }, {
                            key: "getVolume",
                            value: function getVolume() {
                                return this.volume;
                            }
                            /**
                             * Set the audio volume
                             *
                             * @param {number} value A floating point value between 0 and 1.
                             */

                        }, {
                            key: "setVolume",
                            value: function setVolume(value) {
                                this.volume = value; // no need to change when it's already at that volume

                                if (this.media.volume !== this.volume) {
                                    this.media.volume = this.volume;
                                }
                            }
                            /**
                             * Enable or disable muted audio
                             *
                             * @since 4.0.0
                             * @param {boolean} muted Specify `true` to mute audio.
                             */

                        }, {
                            key: "setMute",
                            value: function setMute(muted) {
                                // This causes a volume change to be emitted too through the
                                // volumechange event listener.
                                this.isMuted = this.media.muted = muted;
                            }
                            /**
                             * This is called when wavesurfer is destroyed
                             *
                             */

                        }, {
                            key: "destroy",
                            value: function destroy() {
                                var _this5 = this;

                                this.pause();
                                this.unAll();
                                this.destroyed = true; // cleanup media event listeners

                                Object.keys(this.mediaListeners).forEach(function (id) {
                                    if (_this5.media) {
                                        _this5.media.removeEventListener(id, _this5.mediaListeners[id]);
                                    }
                                });

                                if (this.params.removeMediaElementOnDestroy && this.media && this.media.parentNode) {
                                    this.media.parentNode.removeChild(this.media);
                                }

                                this.media = null;
                            }
                        }]);

                        return MediaElement;
                    }(_webaudio.default);

                exports.default = MediaElement;
                module.exports = exports.default;

                /***/
            }),

            /***/ "./src/peakcache.js":
            /*!**************************!*\
  !*** ./src/peakcache.js ***!
  \**************************/
            /*! no static exports found */
            /***/ (function (module, exports, __webpack_require__) {

                "use strict";


                Object.defineProperty(exports, "__esModule", {
                    value: true
                });
                exports.default = void 0;

                function _classCallCheck(instance, Constructor) {
                    if (!(instance instanceof Constructor)) {
                        throw new TypeError("Cannot call a class as a function");
                    }
                }

                function _defineProperties(target, props) {
                    for (var i = 0; i < props.length; i++) {
                        var descriptor = props[i];
                        descriptor.enumerable = descriptor.enumerable || false;
                        descriptor.configurable = true;
                        if ("value" in descriptor) descriptor.writable = true;
                        Object.defineProperty(target, descriptor.key, descriptor);
                    }
                }

                function _createClass(Constructor, protoProps, staticProps) {
                    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
                    if (staticProps) _defineProperties(Constructor, staticProps);
                    return Constructor;
                }

                /**
                 * Caches the decoded peaks data to improve rendering speed for large audio
                 *
                 * Is used if the option parameter `partialRender` is set to `true`
                 */
                var PeakCache =
                    /*#__PURE__*/
                    function () {
                        /**
                         * Instantiate cache
                         */
                        function PeakCache() {
                            _classCallCheck(this, PeakCache);

                            this.clearPeakCache();
                        }

                        /**
                         * Empty the cache
                         */


                        _createClass(PeakCache, [{
                            key: "clearPeakCache",
                            value: function clearPeakCache() {
                                /**
                                 * Flat array with entries that are always in pairs to mark the
                                 * beginning and end of each subrange.  This is a convenience so we can
                                 * iterate over the pairs for easy set difference operations.
                                 * @private
                                 */
                                this.peakCacheRanges = [];
                                /**
                                 * Length of the entire cachable region, used for resetting the cache
                                 * when this changes (zoom events, for instance).
                                 * @private
                                 */

                                this.peakCacheLength = -1;
                            }
                            /**
                             * Add a range of peaks to the cache
                             *
                             * @param {number} length The length of the range
                             * @param {number} start The x offset of the start of the range
                             * @param {number} end The x offset of the end of the range
                             * @return {Number.<Array[]>} Array with arrays of numbers
                             */

                        }, {
                            key: "addRangeToPeakCache",
                            value: function addRangeToPeakCache(length, start, end) {
                                if (length != this.peakCacheLength) {
                                    this.clearPeakCache();
                                    this.peakCacheLength = length;
                                } // Return ranges that weren't in the cache before the call.


                                var uncachedRanges = [];
                                var i = 0; // Skip ranges before the current start.

                                while (i < this.peakCacheRanges.length && this.peakCacheRanges[i] < start) {
                                    i++;
                                } // If |i| is even, |start| falls after an existing range.  Otherwise,
                                // |start| falls between an existing range, and the uncached region
                                // starts when we encounter the next node in |peakCacheRanges| or
                                // |end|, whichever comes first.


                                if (i % 2 == 0) {
                                    uncachedRanges.push(start);
                                }

                                while (i < this.peakCacheRanges.length && this.peakCacheRanges[i] <= end) {
                                    uncachedRanges.push(this.peakCacheRanges[i]);
                                    i++;
                                } // If |i| is even, |end| is after all existing ranges.


                                if (i % 2 == 0) {
                                    uncachedRanges.push(end);
                                } // Filter out the 0-length ranges.


                                uncachedRanges = uncachedRanges.filter(function (item, pos, arr) {
                                    if (pos == 0) {
                                        return item != arr[pos + 1];
                                    } else if (pos == arr.length - 1) {
                                        return item != arr[pos - 1];
                                    }

                                    return item != arr[pos - 1] && item != arr[pos + 1];
                                }); // Merge the two ranges together, uncachedRanges will either contain
                                // wholly new points, or duplicates of points in peakCacheRanges.  If
                                // duplicates are detected, remove both and extend the range.

                                this.peakCacheRanges = this.peakCacheRanges.concat(uncachedRanges);
                                this.peakCacheRanges = this.peakCacheRanges.sort(function (a, b) {
                                    return a - b;
                                }).filter(function (item, pos, arr) {
                                    if (pos == 0) {
                                        return item != arr[pos + 1];
                                    } else if (pos == arr.length - 1) {
                                        return item != arr[pos - 1];
                                    }

                                    return item != arr[pos - 1] && item != arr[pos + 1];
                                }); // Push the uncached ranges into an array of arrays for ease of
                                // iteration in the functions that call this.

                                var uncachedRangePairs = [];

                                for (i = 0; i < uncachedRanges.length; i += 2) {
                                    uncachedRangePairs.push([uncachedRanges[i], uncachedRanges[i + 1]]);
                                }

                                return uncachedRangePairs;
                            }
                            /**
                             * For testing
                             *
                             * @return {Number.<Array[]>} Array with arrays of numbers
                             */

                        }, {
                            key: "getCacheRanges",
                            value: function getCacheRanges() {
                                var peakCacheRangePairs = [];
                                var i;

                                for (i = 0; i < this.peakCacheRanges.length; i += 2) {
                                    peakCacheRangePairs.push([this.peakCacheRanges[i], this.peakCacheRanges[i + 1]]);
                                }

                                return peakCacheRangePairs;
                            }
                        }]);

                        return PeakCache;
                    }();

                exports.default = PeakCache;
                module.exports = exports.default;

                /***/
            }),

            /***/ "./src/util/ajax.js":
            /*!**************************!*\
  !*** ./src/util/ajax.js ***!
  \**************************/
            /*! no static exports found */
            /***/ (function (module, exports, __webpack_require__) {

                "use strict";


                Object.defineProperty(exports, "__esModule", {
                    value: true
                });
                exports.default = ajax;

                var _observer = _interopRequireDefault(__webpack_require__(/*! ./observer */ "./src/util/observer.js"));

                function _interopRequireDefault(obj) {
                    return obj && obj.__esModule ? obj : {default: obj};
                }

                /**
                 * Perform an ajax request using `XMLHttpRequest`.
                 *
                 * @deprecated Use `util.fetchFile` instead.
                 *
                 * @param {Object} options AJAX options to use. See example below for options.
                 * @returns {Observer} Observer instance
                 * @example
                 * // default options
                 * let options = {
                 *     method: 'GET',
                 *     url: undefined,
                 *     responseType: 'json',
                 *     xhr: {}
                 * };
                 *
                 * // override default options
                 * options.url = '../media/demo.wav';
                 * options.responseType = 'arraybuffer';
                 * options.xhr = {
                 *     requestHeaders: [
                 *         {
                 *             key: 'Authorization',
                 *             value: 'my-token'
                 *         }
                 *     ],
                 *     withCredentials: true
                 * };
                 *
                 * // make ajax call
                 * let ajaxCall = util.ajax(options);
                 * ajaxCall.on('progress', e => {
                 *     console.log('progress', e);
                 * });
                 * ajaxCall.on('success', (data, e) => {
                 *     console.log('success!', data);
                 * });
                 * ajaxCall.on('error', e => {
                 *     console.warn('ajax error: ' + e.target.statusText);
                 * });
                 */
                function ajax(options) {
                    var instance = new _observer.default();
                    var xhr = new XMLHttpRequest();
                    var fired100 = false;
                    xhr.open(options.method || 'GET', options.url, true);
                    xhr.responseType = options.responseType || 'json';

                    if (options.xhr) {
                        if (options.xhr.requestHeaders) {
                            // add custom request headers
                            options.xhr.requestHeaders.forEach(function (header) {
                                xhr.setRequestHeader(header.key, header.value);
                            });
                        }

                        if (options.xhr.withCredentials) {
                            // use credentials
                            xhr.withCredentials = true;
                        }
                    }

                    xhr.addEventListener('progress', function (e) {
                        instance.fireEvent('progress', e);

                        if (e.lengthComputable && e.loaded == e.total) {
                            fired100 = true;
                        }
                    });
                    xhr.addEventListener('load', function (e) {
                        if (!fired100) {
                            instance.fireEvent('progress', e);
                        }

                        instance.fireEvent('load', e);

                        if (200 == xhr.status || 206 == xhr.status) {
                            instance.fireEvent('success', xhr.response, e);
                        } else {
                            instance.fireEvent('error', e);
                        }
                    });
                    xhr.addEventListener('error', function (e) {
                        return instance.fireEvent('error', e);
                    });
                    xhr.send();
                    instance.xhr = xhr;
                    return instance;
                }

                module.exports = exports.default;

                /***/
            }),

            /***/ "./src/util/extend.js":
            /*!****************************!*\
  !*** ./src/util/extend.js ***!
  \****************************/
            /*! no static exports found */
            /***/ (function (module, exports, __webpack_require__) {

                "use strict";


                Object.defineProperty(exports, "__esModule", {
                    value: true
                });
                exports.default = extend;

                /* eslint no-console: ["error", { allow: ["warn"] }] */

                /**
                 * Extend an object shallowly with others
                 *
                 * @param {Object} dest The target object
                 * @param {Object[]} sources The objects to use for extending
                 *
                 * @return {Object} Merged object
                 * @deprecated since version 3.3.0
                 */
                function extend(dest) {
                    console.warn('util.extend is deprecated; use Object.assign instead');

                    for (var _len = arguments.length, sources = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
                        sources[_key - 1] = arguments[_key];
                    }

                    sources.forEach(function (source) {
                        Object.keys(source).forEach(function (key) {
                            dest[key] = source[key];
                        });
                    });
                    return dest;
                }

                module.exports = exports.default;

                /***/
            }),

            /***/ "./src/util/fetch.js":
            /*!***************************!*\
  !*** ./src/util/fetch.js ***!
  \***************************/
            /*! no static exports found */
            /***/ (function (module, exports, __webpack_require__) {

                "use strict";


                Object.defineProperty(exports, "__esModule", {
                    value: true
                });
                exports.default = fetchFile;

                var _observer = _interopRequireDefault(__webpack_require__(/*! ./observer */ "./src/util/observer.js"));

                function _interopRequireDefault(obj) {
                    return obj && obj.__esModule ? obj : {default: obj};
                }

                function _classCallCheck(instance, Constructor) {
                    if (!(instance instanceof Constructor)) {
                        throw new TypeError("Cannot call a class as a function");
                    }
                }

                function _defineProperties(target, props) {
                    for (var i = 0; i < props.length; i++) {
                        var descriptor = props[i];
                        descriptor.enumerable = descriptor.enumerable || false;
                        descriptor.configurable = true;
                        if ("value" in descriptor) descriptor.writable = true;
                        Object.defineProperty(target, descriptor.key, descriptor);
                    }
                }

                function _createClass(Constructor, protoProps, staticProps) {
                    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
                    if (staticProps) _defineProperties(Constructor, staticProps);
                    return Constructor;
                }

                var ProgressHandler =
                    /*#__PURE__*/
                    function () {
                        /**
                         * Instantiate ProgressHandler
                         *
                         * @param {Observer} instance The `fetchFile` observer instance.
                         * @param {Number} contentLength Content length.
                         * @param {Response} response Response object.
                         */
                        function ProgressHandler(instance, contentLength, response) {
                            _classCallCheck(this, ProgressHandler);

                            this.instance = instance;
                            this.instance._reader = response.body.getReader();
                            this.total = parseInt(contentLength, 10);
                            this.loaded = 0;
                        }

                        /**
                         * A method that is called once, immediately after the `ReadableStream``
                         * is constructed.
                         *
                         * @param {ReadableStreamDefaultController} controller Controller instance
                         *     used to control the stream.
                         */


                        _createClass(ProgressHandler, [{
                            key: "start",
                            value: function start(controller) {
                                var _this = this;

                                var read = function read() {
                                    // instance._reader.read() returns a promise that resolves
                                    // when a value has been received
                                    _this.instance._reader.read().then(function (_ref) {
                                        var done = _ref.done,
                                            value = _ref.value;

                                        // result objects contain two properties:
                                        // done  - true if the stream has already given you all its data.
                                        // value - some data. Always undefined when done is true.
                                        if (done) {
                                            // ensure onProgress called when content-length=0
                                            if (_this.total === 0) {
                                                _this.instance.onProgress.call(_this.instance, {
                                                    loaded: _this.loaded,
                                                    total: _this.total,
                                                    lengthComputable: false
                                                });
                                            } // no more data needs to be consumed, close the stream


                                            controller.close();
                                            return;
                                        }

                                        _this.loaded += value.byteLength;

                                        _this.instance.onProgress.call(_this.instance, {
                                            loaded: _this.loaded,
                                            total: _this.total,
                                            lengthComputable: !(_this.total === 0)
                                        }); // enqueue the next data chunk into our target stream


                                        controller.enqueue(value);
                                        read();
                                    }).catch(function (error) {
                                        controller.error(error);
                                    });
                                };

                                read();
                            }
                        }]);

                        return ProgressHandler;
                    }();

                /**
                 * Load a file using `fetch`.
                 *
                 * @param {object} options Request options to use. See example below.
                 * @returns {Observer} Observer instance
                 * @example
                 * // default options
                 * let options = {
                 *     url: undefined,
                 *     method: 'GET',
                 *     mode: 'cors',
                 *     credentials: 'same-origin',
                 *     cache: 'default',
                 *     responseType: 'json',
                 *     requestHeaders: [],
                 *     redirect: 'follow',
                 *     referrer: 'client'
                 * };
                 *
                 * // override some options
                 * options.url = '../media/demo.wav';

                 * // available types: 'arraybuffer', 'blob', 'json' or 'text'
                 * options.responseType = 'arraybuffer';
                 *
                 * // make fetch call
                 * let request = util.fetchFile(options);
                 *
                 * // listen for events
                 * request.on('progress', e => {
                 *     console.log('progress', e);
                 * });
                 *
                 * request.on('success', data => {
                 *     console.log('success!', data);
                 * });
                 *
                 * request.on('error', e => {
                 *     console.warn('fetchFile error: ', e);
                 * });
                 */


                function fetchFile(options) {
                    if (!options) {
                        throw new Error('fetch options missing');
                    } else if (!options.url) {
                        throw new Error('fetch url missing');
                    }

                    var instance = new _observer.default();
                    var fetchHeaders = new Headers();
                    var fetchRequest = new Request(options.url); // add ability to abort

                    instance.controller = new AbortController(); // check if headers have to be added

                    if (options && options.requestHeaders) {
                        // add custom request headers
                        options.requestHeaders.forEach(function (header) {
                            fetchHeaders.append(header.key, header.value);
                        });
                    } // parse fetch options

                    var responseType = options.responseType || 'json';
                    var fetchOptions = {
                        method: options.method || 'GET',
                        headers: fetchHeaders,
                        mode: options.mode || 'cors',
                        credentials: options.credentials || 'same-origin',
                        cache: options.cache || 'default',
                        redirect: options.redirect || 'follow',
                        referrer: options.referrer || 'client',
                        signal: instance.controller.signal
                    };
                    fetch(fetchRequest, fetchOptions).then(function (response) {
                        // store response reference
                        instance.response = response;
                        var progressAvailable = true;

                        if (!response.body) {
                            // ReadableStream is not yet supported in this browser
                            // see https://developer.mozilla.org/en-US/docs/Web/API/ReadableStream
                            progressAvailable = false;
                        } // Server must send CORS header "Access-Control-Expose-Headers: content-length"


                        var contentLength = response.headers.get('content-length');

                        if (contentLength === null) {
                            // Content-Length server response header missing.
                            // Don't evaluate download progress if we can't compare against a total size
                            // see https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS#Access-Control-Expose-Headers
                            progressAvailable = false;
                        }

                        if (!progressAvailable) {
                            // not able to check download progress so skip it
                            return response;
                        } // fire progress event when during load


                        instance.onProgress = function (e) {
                            instance.fireEvent('progress', e);
                        };

                        return new Response(new ReadableStream(new ProgressHandler(instance, contentLength, response)), fetchOptions);
                    }).then(function (response) {
                        var errMsg;

                        if (response.ok) {
                            switch (responseType) {
                                case 'arraybuffer':
                                    return response.arrayBuffer();

                                case 'json':
                                    return response.json();

                                case 'blob':
                                    return response.blob();

                                case 'text':
                                    return response.text();

                                default:
                                    errMsg = 'Unknown responseType: ' + responseType;
                                    break;
                            }
                        }

                        if (!errMsg) {
                            errMsg = 'HTTP error status: ' + response.status;
                        }

                        throw new Error(errMsg);
                    }).then(function (response) {
                        instance.fireEvent('success', response);
                    }).catch(function (error) {
                        instance.fireEvent('error', error);
                    }); // return the fetch request

                    instance.fetchRequest = fetchRequest;
                    return instance;
                }

                module.exports = exports.default;

                /***/
            }),

            /***/ "./src/util/frame.js":
            /*!***************************!*\
  !*** ./src/util/frame.js ***!
  \***************************/
            /*! no static exports found */
            /***/ (function (module, exports, __webpack_require__) {

                "use strict";


                Object.defineProperty(exports, "__esModule", {
                    value: true
                });
                exports.default = frame;

                var _requestAnimationFrame = _interopRequireDefault(__webpack_require__(/*! ./request-animation-frame */ "./src/util/request-animation-frame.js"));

                function _interopRequireDefault(obj) {
                    return obj && obj.__esModule ? obj : {default: obj};
                }

                /**
                 * Create a function which will be called at the next requestAnimationFrame
                 * cycle
                 *
                 * @param {function} func The function to call
                 *
                 * @return {func} The function wrapped within a requestAnimationFrame
                 */
                function frame(func) {
                    return function () {
                        for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
                            args[_key] = arguments[_key];
                        }

                        return (0, _requestAnimationFrame.default)(function () {
                            return func.apply(void 0, args);
                        });
                    };
                }

                module.exports = exports.default;

                /***/
            }),

            /***/ "./src/util/get-id.js":
            /*!****************************!*\
  !*** ./src/util/get-id.js ***!
  \****************************/
            /*! no static exports found */
            /***/ (function (module, exports, __webpack_require__) {

                "use strict";


                Object.defineProperty(exports, "__esModule", {
                    value: true
                });
                exports.default = getId;

                /**
                 * Get a random prefixed ID
                 *
                 * @param {String} prefix Prefix to use. Default is `'wavesurfer_'`.
                 * @returns {String} Random prefixed ID
                 * @example
                 * console.log(getId()); // logs 'wavesurfer_b5pors4ru6g'
                 *
                 * let prefix = 'foo-';
                 * console.log(getId(prefix)); // logs 'foo-b5pors4ru6g'
                 */
                function getId(prefix) {
                    if (prefix === undefined) {
                        prefix = 'wavesurfer_';
                    }

                    return prefix + Math.random().toString(32).substring(2);
                }

                module.exports = exports.default;

                /***/
            }),

            /***/ "./src/util/index.js":
            /*!***************************!*\
  !*** ./src/util/index.js ***!
  \***************************/
            /*! no static exports found */
            /***/ (function (module, exports, __webpack_require__) {

                "use strict";


                Object.defineProperty(exports, "__esModule", {
                    value: true
                });
                Object.defineProperty(exports, "ajax", {
                    enumerable: true,
                    get: function get() {
                        return _ajax.default;
                    }
                });
                Object.defineProperty(exports, "getId", {
                    enumerable: true,
                    get: function get() {
                        return _getId.default;
                    }
                });
                Object.defineProperty(exports, "max", {
                    enumerable: true,
                    get: function get() {
                        return _max.default;
                    }
                });
                Object.defineProperty(exports, "min", {
                    enumerable: true,
                    get: function get() {
                        return _min.default;
                    }
                });
                Object.defineProperty(exports, "Observer", {
                    enumerable: true,
                    get: function get() {
                        return _observer.default;
                    }
                });
                Object.defineProperty(exports, "extend", {
                    enumerable: true,
                    get: function get() {
                        return _extend.default;
                    }
                });
                Object.defineProperty(exports, "style", {
                    enumerable: true,
                    get: function get() {
                        return _style.default;
                    }
                });
                Object.defineProperty(exports, "requestAnimationFrame", {
                    enumerable: true,
                    get: function get() {
                        return _requestAnimationFrame.default;
                    }
                });
                Object.defineProperty(exports, "frame", {
                    enumerable: true,
                    get: function get() {
                        return _frame.default;
                    }
                });
                Object.defineProperty(exports, "debounce", {
                    enumerable: true,
                    get: function get() {
                        return _debounce.default;
                    }
                });
                Object.defineProperty(exports, "preventClick", {
                    enumerable: true,
                    get: function get() {
                        return _preventClick.default;
                    }
                });
                Object.defineProperty(exports, "fetchFile", {
                    enumerable: true,
                    get: function get() {
                        return _fetch.default;
                    }
                });

                var _ajax = _interopRequireDefault(__webpack_require__(/*! ./ajax */ "./src/util/ajax.js"));

                var _getId = _interopRequireDefault(__webpack_require__(/*! ./get-id */ "./src/util/get-id.js"));

                var _max = _interopRequireDefault(__webpack_require__(/*! ./max */ "./src/util/max.js"));

                var _min = _interopRequireDefault(__webpack_require__(/*! ./min */ "./src/util/min.js"));

                var _observer = _interopRequireDefault(__webpack_require__(/*! ./observer */ "./src/util/observer.js"));

                var _extend = _interopRequireDefault(__webpack_require__(/*! ./extend */ "./src/util/extend.js"));

                var _style = _interopRequireDefault(__webpack_require__(/*! ./style */ "./src/util/style.js"));

                var _requestAnimationFrame = _interopRequireDefault(__webpack_require__(/*! ./request-animation-frame */ "./src/util/request-animation-frame.js"));

                var _frame = _interopRequireDefault(__webpack_require__(/*! ./frame */ "./src/util/frame.js"));

                var _debounce = _interopRequireDefault(__webpack_require__(/*! debounce */ "./node_modules/debounce/index.js"));

                var _preventClick = _interopRequireDefault(__webpack_require__(/*! ./prevent-click */ "./src/util/prevent-click.js"));

                var _fetch = _interopRequireDefault(__webpack_require__(/*! ./fetch */ "./src/util/fetch.js"));

                function _interopRequireDefault(obj) {
                    return obj && obj.__esModule ? obj : {default: obj};
                }

                /***/
            }),

            /***/ "./src/util/max.js":
            /*!*************************!*\
  !*** ./src/util/max.js ***!
  \*************************/
            /*! no static exports found */
            /***/ (function (module, exports, __webpack_require__) {

                "use strict";


                Object.defineProperty(exports, "__esModule", {
                    value: true
                });
                exports.default = max;

                /**
                 * Get the largest value
                 *
                 * @param   {Array} values Array of numbers
                 * @returns {Number} Largest number found
                 * @example console.log(max([1, 2, 3])); // logs 3
                 */
                function max(values) {
                    var largest = -Infinity;
                    Object.keys(values).forEach(function (i) {
                        if (values[i] > largest) {
                            largest = values[i];
                        }
                    });
                    return largest;
                }

                module.exports = exports.default;

                /***/
            }),

            /***/ "./src/util/min.js":
            /*!*************************!*\
  !*** ./src/util/min.js ***!
  \*************************/
            /*! no static exports found */
            /***/ (function (module, exports, __webpack_require__) {

                "use strict";


                Object.defineProperty(exports, "__esModule", {
                    value: true
                });
                exports.default = min;

                /**
                 * Get the smallest value
                 *
                 * @param   {Array} values Array of numbers
                 * @returns {Number} Smallest number found
                 * @example console.log(min([1, 2, 3])); // logs 1
                 */
                function min(values) {
                    var smallest = Number(Infinity);
                    Object.keys(values).forEach(function (i) {
                        if (values[i] < smallest) {
                            smallest = values[i];
                        }
                    });
                    return smallest;
                }

                module.exports = exports.default;

                /***/
            }),

            /***/ "./src/util/observer.js":
            /*!******************************!*\
  !*** ./src/util/observer.js ***!
  \******************************/
            /*! no static exports found */
            /***/ (function (module, exports, __webpack_require__) {

                "use strict";


                Object.defineProperty(exports, "__esModule", {
                    value: true
                });
                exports.default = void 0;

                function _classCallCheck(instance, Constructor) {
                    if (!(instance instanceof Constructor)) {
                        throw new TypeError("Cannot call a class as a function");
                    }
                }

                function _defineProperties(target, props) {
                    for (var i = 0; i < props.length; i++) {
                        var descriptor = props[i];
                        descriptor.enumerable = descriptor.enumerable || false;
                        descriptor.configurable = true;
                        if ("value" in descriptor) descriptor.writable = true;
                        Object.defineProperty(target, descriptor.key, descriptor);
                    }
                }

                function _createClass(Constructor, protoProps, staticProps) {
                    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
                    if (staticProps) _defineProperties(Constructor, staticProps);
                    return Constructor;
                }

                /**
                 * @typedef {Object} ListenerDescriptor
                 * @property {string} name The name of the event
                 * @property {function} callback The callback
                 * @property {function} un The function to call to remove the listener
                 */

                /**
                 * Observer class
                 */
                var Observer =
                    /*#__PURE__*/
                    function () {
                        /**
                         * Instantiate Observer
                         */
                        function Observer() {
                            _classCallCheck(this, Observer);

                            /**
                             * @private
                             * @todo Initialise the handlers here already and remove the conditional
                             * assignment in `on()`
                             */
                            this._disabledEventEmissions = [];
                            this.handlers = null;
                        }

                        /**
                         * Attach a handler function for an event.
                         *
                         * @param {string} event Name of the event to listen to
                         * @param {function} fn The callback to trigger when the event is fired
                         * @return {ListenerDescriptor} The event descriptor
                         */


                        _createClass(Observer, [{
                            key: "on",
                            value: function on(event, fn) {
                                var _this = this;

                                if (!this.handlers) {
                                    this.handlers = {};
                                }

                                var handlers = this.handlers[event];

                                if (!handlers) {
                                    handlers = this.handlers[event] = [];
                                }

                                handlers.push(fn); // Return an event descriptor

                                return {
                                    name: event,
                                    callback: fn,
                                    un: function un(e, fn) {
                                        return _this.un(e, fn);
                                    }
                                };
                            }
                            /**
                             * Remove an event handler.
                             *
                             * @param {string} event Name of the event the listener that should be
                             * removed listens to
                             * @param {function} fn The callback that should be removed
                             */

                        }, {
                            key: "un",
                            value: function un(event, fn) {
                                if (!this.handlers) {
                                    return;
                                }

                                var handlers = this.handlers[event];
                                var i;

                                if (handlers) {
                                    if (fn) {
                                        for (i = handlers.length - 1; i >= 0; i--) {
                                            if (handlers[i] == fn) {
                                                handlers.splice(i, 1);
                                            }
                                        }
                                    } else {
                                        handlers.length = 0;
                                    }
                                }
                            }
                            /**
                             * Remove all event handlers.
                             */

                        }, {
                            key: "unAll",
                            value: function unAll() {
                                this.handlers = null;
                            }
                            /**
                             * Attach a handler to an event. The handler is executed at most once per
                             * event type.
                             *
                             * @param {string} event The event to listen to
                             * @param {function} handler The callback that is only to be called once
                             * @return {ListenerDescriptor} The event descriptor
                             */

                        }, {
                            key: "once",
                            value: function once(event, handler) {
                                var _this2 = this;

                                var fn = function fn() {
                                    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
                                        args[_key] = arguments[_key];
                                    }

                                    /*  eslint-disable no-invalid-this */
                                    handler.apply(_this2, args);
                                    /*  eslint-enable no-invalid-this */

                                    setTimeout(function () {
                                        _this2.un(event, fn);
                                    }, 0);
                                };

                                return this.on(event, fn);
                            }
                            /**
                             * Disable firing a list of events by name. When specified, event handlers for any event type
                             * passed in here will not be called.
                             *
                             * @since 4.0.0
                             * @param {string[]} eventNames an array of event names to disable emissions for
                             * @example
                             * // disable seek and interaction events
                             * wavesurfer.setDisabledEventEmissions(['seek', 'interaction']);
                             */

                        }, {
                            key: "setDisabledEventEmissions",
                            value: function setDisabledEventEmissions(eventNames) {
                                this._disabledEventEmissions = eventNames;
                            }
                            /**
                             * plugins borrow part of this class without calling the constructor,
                             * so we have to be careful about _disabledEventEmissions
                             */

                        }, {
                            key: "_isDisabledEventEmission",
                            value: function _isDisabledEventEmission(event) {
                                return this._disabledEventEmissions && this._disabledEventEmissions.includes(event);
                            }
                            /**
                             * Manually fire an event
                             *
                             * @param {string} event The event to fire manually
                             * @param {...any} args The arguments with which to call the listeners
                             */

                        }, {
                            key: "fireEvent",
                            value: function fireEvent(event) {
                                for (var _len2 = arguments.length, args = new Array(_len2 > 1 ? _len2 - 1 : 0), _key2 = 1; _key2 < _len2; _key2++) {
                                    args[_key2 - 1] = arguments[_key2];
                                }

                                if (!this.handlers || this._isDisabledEventEmission(event)) {
                                    return;
                                }

                                var handlers = this.handlers[event];
                                handlers && handlers.forEach(function (fn) {
                                    fn.apply(void 0, args);
                                });
                            }
                        }]);

                        return Observer;
                    }();

                exports.default = Observer;
                module.exports = exports.default;

                /***/
            }),

            /***/ "./src/util/prevent-click.js":
            /*!***********************************!*\
  !*** ./src/util/prevent-click.js ***!
  \***********************************/
            /*! no static exports found */
            /***/ (function (module, exports, __webpack_require__) {

                "use strict";


                Object.defineProperty(exports, "__esModule", {
                    value: true
                });
                exports.default = preventClick;

                /**
                 * Stops propagation of click event and removes event listener
                 *
                 * @private
                 * @param {object} event The click event
                 */
                function preventClickHandler(event) {
                    event.stopPropagation();
                    document.body.removeEventListener('click', preventClickHandler, true);
                }

                /**
                 * Starts listening for click event and prevent propagation
                 *
                 * @param {object} values Values
                 */


                function preventClick(values) {
                    document.body.addEventListener('click', preventClickHandler, true);
                }

                module.exports = exports.default;

                /***/
            }),

            /***/ "./src/util/request-animation-frame.js":
            /*!*********************************************!*\
  !*** ./src/util/request-animation-frame.js ***!
  \*********************************************/
            /*! no static exports found */
            /***/ (function (module, exports, __webpack_require__) {

                "use strict";


                Object.defineProperty(exports, "__esModule", {
                    value: true
                });
                exports.default = void 0;

                /* eslint-disable valid-jsdoc */

                /**
                 * Returns the `requestAnimationFrame` function for the browser, or a shim with
                 * `setTimeout` if the function is not found
                 *
                 * @return {function} Available `requestAnimationFrame` function for the browser
                 */
                var _default = (window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function (callback, element) {
                    return setTimeout(callback, 1000 / 60);
                }).bind(window);

                exports.default = _default;
                module.exports = exports.default;

                /***/
            }),

            /***/ "./src/util/style.js":
            /*!***************************!*\
  !*** ./src/util/style.js ***!
  \***************************/
            /*! no static exports found */
            /***/ (function (module, exports, __webpack_require__) {

                "use strict";


                Object.defineProperty(exports, "__esModule", {
                    value: true
                });
                exports.default = style;

                /**
                 * Apply a map of styles to an element
                 *
                 * @param {HTMLElement} el The element that the styles will be applied to
                 * @param {Object} styles The map of propName: attribute, both are used as-is
                 *
                 * @return {HTMLElement} el
                 */
                function style(el, styles) {
                    Object.keys(styles).forEach(function (prop) {
                        if (el.style[prop] !== styles[prop]) {
                            el.style[prop] = styles[prop];
                        }
                    });
                    return el;
                }

                module.exports = exports.default;

                /***/
            }),

            /***/ "./src/wavesurfer.js":
            /*!***************************!*\
  !*** ./src/wavesurfer.js ***!
  \***************************/
            /*! no static exports found */
            /***/ (function (module, exports, __webpack_require__) {

                "use strict";


                Object.defineProperty(exports, "__esModule", {
                    value: true
                });
                exports.default = void 0;

                var util = _interopRequireWildcard(__webpack_require__(/*! ./util */ "./src/util/index.js"));

                var _drawer = _interopRequireDefault(__webpack_require__(/*! ./drawer.multicanvas */ "./src/drawer.multicanvas.js"));

                var _webaudio = _interopRequireDefault(__webpack_require__(/*! ./webaudio */ "./src/webaudio.js"));

                var _mediaelement = _interopRequireDefault(__webpack_require__(/*! ./mediaelement */ "./src/mediaelement.js"));

                var _peakcache = _interopRequireDefault(__webpack_require__(/*! ./peakcache */ "./src/peakcache.js"));

                var _mediaelementWebaudio = _interopRequireDefault(__webpack_require__(/*! ./mediaelement-webaudio */ "./src/mediaelement-webaudio.js"));

                function _interopRequireDefault(obj) {
                    return obj && obj.__esModule ? obj : {default: obj};
                }

                function _getRequireWildcardCache() {
                    if (typeof WeakMap !== "function") return null;
                    var cache = new WeakMap();
                    _getRequireWildcardCache = function _getRequireWildcardCache() {
                        return cache;
                    };
                    return cache;
                }

                function _interopRequireWildcard(obj) {
                    if (obj && obj.__esModule) {
                        return obj;
                    }
                    if (obj === null || _typeof(obj) !== "object" && typeof obj !== "function") {
                        return {default: obj};
                    }
                    var cache = _getRequireWildcardCache();
                    if (cache && cache.has(obj)) {
                        return cache.get(obj);
                    }
                    var newObj = {};
                    var hasPropertyDescriptor = Object.defineProperty && Object.getOwnPropertyDescriptor;
                    for (var key in obj) {
                        if (Object.prototype.hasOwnProperty.call(obj, key)) {
                            var desc = hasPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : null;
                            if (desc && (desc.get || desc.set)) {
                                Object.defineProperty(newObj, key, desc);
                            } else {
                                newObj[key] = obj[key];
                            }
                        }
                    }
                    newObj.default = obj;
                    if (cache) {
                        cache.set(obj, newObj);
                    }
                    return newObj;
                }

                function _typeof(obj) {
                    if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
                        _typeof = function _typeof(obj) {
                            return typeof obj;
                        };
                    } else {
                        _typeof = function _typeof(obj) {
                            return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
                        };
                    }
                    return _typeof(obj);
                }

                function _possibleConstructorReturn(self, call) {
                    if (call && (_typeof(call) === "object" || typeof call === "function")) {
                        return call;
                    }
                    return _assertThisInitialized(self);
                }

                function _getPrototypeOf(o) {
                    _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
                        return o.__proto__ || Object.getPrototypeOf(o);
                    };
                    return _getPrototypeOf(o);
                }

                function _assertThisInitialized(self) {
                    if (self === void 0) {
                        throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                    }
                    return self;
                }

                function _inherits(subClass, superClass) {
                    if (typeof superClass !== "function" && superClass !== null) {
                        throw new TypeError("Super expression must either be null or a function");
                    }
                    subClass.prototype = Object.create(superClass && superClass.prototype, {
                        constructor: {
                            value: subClass,
                            writable: true,
                            configurable: true
                        }
                    });
                    if (superClass) _setPrototypeOf(subClass, superClass);
                }

                function _setPrototypeOf(o, p) {
                    _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
                        o.__proto__ = p;
                        return o;
                    };
                    return _setPrototypeOf(o, p);
                }

                function _classCallCheck(instance, Constructor) {
                    if (!(instance instanceof Constructor)) {
                        throw new TypeError("Cannot call a class as a function");
                    }
                }

                function _defineProperties(target, props) {
                    for (var i = 0; i < props.length; i++) {
                        var descriptor = props[i];
                        descriptor.enumerable = descriptor.enumerable || false;
                        descriptor.configurable = true;
                        if ("value" in descriptor) descriptor.writable = true;
                        Object.defineProperty(target, descriptor.key, descriptor);
                    }
                }

                function _createClass(Constructor, protoProps, staticProps) {
                    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
                    if (staticProps) _defineProperties(Constructor, staticProps);
                    return Constructor;
                }

                /*
 * This work is licensed under a BSD-3-Clause License.
 */

                /** @external {HTMLElement} https://developer.mozilla.org/en/docs/Web/API/HTMLElement */

                /** @external {OfflineAudioContext} https://developer.mozilla.org/en-US/docs/Web/API/OfflineAudioContext */

                /** @external {File} https://developer.mozilla.org/en-US/docs/Web/API/File */

                /** @external {Blob} https://developer.mozilla.org/en-US/docs/Web/API/Blob */

                /** @external {CanvasRenderingContext2D} https://developer.mozilla.org/en-US/docs/Web/API/CanvasRenderingContext2D */

                /** @external {MediaStreamConstraints} https://developer.mozilla.org/en-US/docs/Web/API/MediaStreamConstraints */

                /** @external {AudioNode} https://developer.mozilla.org/de/docs/Web/API/AudioNode */

                /**
                 * @typedef {Object} WavesurferParams
                 * @property {AudioContext} audioContext=null Use your own previously
                 * initialized AudioContext or leave blank.
                 * @property {number} audioRate=1 Speed at which to play audio. Lower number is
                 * slower.
                 * @property {ScriptProcessorNode} audioScriptProcessor=null Use your own previously
                 * initialized ScriptProcessorNode or leave blank.
                 * @property {boolean} autoCenter=true If a scrollbar is present, center the
                 * waveform on current progress
                 * @property {number} autoCenterRate=5 If autoCenter is active, rate at which the
                 * waveform is centered
                 * @property {boolean} autoCenterImmediately=false If autoCenter is active, immediately
                 * center waveform on current progress
                 * @property {string} backend='WebAudio' `'WebAudio'|'MediaElement'|'MediaElementWebAudio'` In most cases
                 * you don't have to set this manually. MediaElement is a fallback for unsupported browsers.
                 * MediaElementWebAudio allows to use WebAudio API also with big audio files, loading audio like with
                 * MediaElement backend (HTML5 audio tag). You have to use the same methods of MediaElement backend for loading and
                 * playback, giving also peaks, so the audio data are not decoded. In this way you can use WebAudio features, like filters,
                 * also with audio with big duration. For example:
                 * ` wavesurfer.load(url | HTMLMediaElement, peaks, preload, duration);
                 *   wavesurfer.play();
                 *   wavesurfer.setFilter(customFilter);
                 * `
                 * @property {string} backgroundColor=null Change background color of the
                 * waveform container.
                 * @property {number} barHeight=1 The height of the wave bars.
                 * @property {number} barRadius=0 The radius of the wave bars. Makes bars rounded
                 * @property {number} barGap=null The optional spacing between bars of the wave,
                 * if not provided will be calculated in legacy format.
                 * @property {number} barWidth=null Draw the waveform using bars.
                 * @property {number} barMinHeight=null If specified, draw at least a bar of this height,
                 * eliminating waveform gaps
                 * @property {boolean} closeAudioContext=false Close and nullify all audio
                 * contexts when the destroy method is called.
                 * @property {!string|HTMLElement} container CSS selector or HTML element where
                 * the waveform should be drawn. This is the only required parameter.
                 * @property {string} cursorColor='#333' The fill color of the cursor indicating
                 * the playhead position.
                 * @property {number} cursorWidth=1 Measured in pixels.
                 * @property {object} drawingContextAttributes={desynchronized: false} Drawing context
                 * attributes.
                 * @property {number} duration=null Optional audio length so pre-rendered peaks
                 * can be display immediately for example.
                 * @property {boolean} fillParent=true Whether to fill the entire container or
                 * draw only according to `minPxPerSec`.
                 * @property {boolean} forceDecode=false Force decoding of audio using web audio
                 * when zooming to get a more detailed waveform.
                 * @property {number} height=128 The height of the waveform. Measured in
                 * pixels.
                 * @property {boolean} hideScrollbar=false Whether to hide the horizontal
                 * scrollbar when one would normally be shown.
                 * @property {boolean} interact=true Whether the mouse interaction will be
                 * enabled at initialization. You can switch this parameter at any time later
                 * on.
                 * @property {boolean} loopSelection=true (Use with regions plugin) Enable
                 * looping of selected regions
                 * @property {number} maxCanvasWidth=4000 Maximum width of a single canvas in
                 * pixels, excluding a small overlap (2 * `pixelRatio`, rounded up to the next
                 * even integer). If the waveform is longer than this value, additional canvases
                 * will be used to render the waveform, which is useful for very large waveforms
                 * that may be too wide for browsers to draw on a single canvas.
                 * @property {boolean} mediaControls=false (Use with backend `MediaElement` or `MediaElementWebAudio`)
                 * this enables the native controls for the media element
                 * @property {string} mediaType='audio' (Use with backend `MediaElement` or `MediaElementWebAudio`)
                 * `'audio'|'video'` ('video' only for `MediaElement`)
                 * @property {number} minPxPerSec=20 Minimum number of pixels per second of
                 * audio.
                 * @property {boolean} normalize=false If true, normalize by the maximum peak
                 * instead of 1.0.
                 * @property {boolean} partialRender=false Use the PeakCache to improve
                 * rendering speed of large waveforms
                 * @property {number} pixelRatio=window.devicePixelRatio The pixel ratio used to
                 * calculate display
                 * @property {PluginDefinition[]} plugins=[] An array of plugin definitions to
                 * register during instantiation, they will be directly initialised unless they
                 * are added with the `deferInit` property set to true.
                 * @property {string} progressColor='#555' The fill color of the part of the
                 * waveform behind the cursor. When `progressColor` and `waveColor` are the same
                 * the progress wave is not rendered at all.
                 * @property {boolean} removeMediaElementOnDestroy=true Set to false to keep the
                 * media element in the DOM when the player is destroyed. This is useful when
                 * reusing an existing media element via the `loadMediaElement` method.
                 * @property {Object} renderer=MultiCanvas Can be used to inject a custom
                 * renderer.
                 * @property {boolean|number} responsive=false If set to `true` resize the
                 * waveform, when the window is resized. This is debounced with a `100ms`
                 * timeout by default. If this parameter is a number it represents that timeout.
                 * @property {boolean} rtl=false If set to `true`, renders waveform from
                 * right-to-left.
                 * @property {boolean} scrollParent=false Whether to scroll the container with a
                 * lengthy waveform. Otherwise the waveform is shrunk to the container width
                 * (see fillParent).
                 * @property {number} skipLength=2 Number of seconds to skip with the
                 * skipForward() and skipBackward() methods.
                 * @property {boolean} splitChannels=false Render with separate waveforms for
                 * the channels of the audio
                 * @property {string} waveColor='#999' The fill color of the waveform after the
                 * cursor.
                 * @property {object} xhr={} XHR options. For example:
                 * `let xhr = {
                 *     cache: 'default',
                 *     mode: 'cors',
                 *     method: 'GET',
                 *     credentials: 'same-origin',
                 *     redirect: 'follow',
                 *     referrer: 'client',
                 *     headers: [
                 *         {
                 *             key: 'Authorization',
                 *             value: 'my-token'
                 *         }
                 *     ]
                 * };`
                 */

                /**
                 * @typedef {Object} PluginDefinition
                 * @desc The Object used to describe a plugin
                 * @example wavesurfer.addPlugin(pluginDefinition);
                 * @property {string} name The name of the plugin, the plugin instance will be
                 * added as a property to the wavesurfer instance under this name
                 * @property {?Object} staticProps The properties that should be added to the
                 * wavesurfer instance as static properties
                 * @property {?boolean} deferInit Don't initialise plugin
                 * automatically
                 * @property {Object} params={} The plugin parameters, they are the first parameter
                 * passed to the plugin class constructor function
                 * @property {PluginClass} instance The plugin instance factory, is called with
                 * the dependency specified in extends. Returns the plugin class.
                 */

                /**
                 * @interface PluginClass
                 *
                 * @desc This is the interface which is implemented by all plugin classes. Note
                 * that this only turns into an observer after being passed through
                 * `wavesurfer.addPlugin`.
                 *
                 * @extends {Observer}
                 */
                var PluginClass =
                    /*#__PURE__*/
                    function () {
                        _createClass(PluginClass, [{
                            key: "create",

                            /**
                             * Plugin definition factory
                             *
                             * This function must be used to create a plugin definition which can be
                             * used by wavesurfer to correctly instantiate the plugin.
                             *
                             * It returns a `PluginDefinition` object representing the plugin.
                             *
                             * @param {Object} params={} The plugin params (specific to the plugin)
                             */
                            value: function create(params) {
                            }
                            /**
                             * Construct the plugin
                             *
                             * @param {Object} params={} The plugin params (specific to the plugin)
                             * @param {Object} ws The wavesurfer instance
                             */

                        }]);

                        function PluginClass(params, ws) {
                            _classCallCheck(this, PluginClass);
                        }

                        /**
                         * Initialise the plugin
                         *
                         * Start doing something. This is called by
                         * `wavesurfer.initPlugin(pluginName)`
                         */


                        _createClass(PluginClass, [{
                            key: "init",
                            value: function init() {
                            }
                            /**
                             * Destroy the plugin instance
                             *
                             * Stop doing something. This is called by
                             * `wavesurfer.destroyPlugin(pluginName)`
                             */

                        }, {
                            key: "destroy",
                            value: function destroy() {
                            }
                        }]);

                        return PluginClass;
                    }();
                /**
                 * WaveSurfer core library class
                 *
                 * @extends {Observer}
                 * @example
                 * const params = {
                 *   container: '#waveform',
                 *   waveColor: 'violet',
                 *   progressColor: 'purple'
                 * };
                 *
                 * // initialise like this
                 * const wavesurfer = WaveSurfer.create(params);
                 *
                 * // or like this ...
                 * const wavesurfer = new WaveSurfer(params);
                 * wavesurfer.init();
                 *
                 * // load audio file
                 * wavesurfer.load('example/media/demo.wav');
                 */


                var WaveSurfer =
                    /*#__PURE__*/
                    function (_util$Observer) {
                        _inherits(WaveSurfer, _util$Observer);

                        _createClass(WaveSurfer, null, [{
                            key: "create",

                            /** @private */

                            /** @private */

                            /**
                             * Instantiate this class, call its `init` function and returns it
                             *
                             * @param {WavesurferParams} params The wavesurfer parameters
                             * @return {Object} WaveSurfer instance
                             * @example const wavesurfer = WaveSurfer.create(params);
                             */
                            value: function create(params) {
                                var wavesurfer = new WaveSurfer(params);
                                return wavesurfer.init();
                            }
                            /**
                             * The library version number is available as a static property of the
                             * WaveSurfer class
                             *
                             * @type {String}
                             * @example
                             * console.log('Using wavesurfer.js ' + WaveSurfer.VERSION);
                             */

                        }]);

                        /**
                         * Initialise wavesurfer instance
                         *
                         * @param {WavesurferParams} params Instantiation options for wavesurfer
                         * @example
                         * const wavesurfer = new WaveSurfer(params);
                         * @returns {this} Wavesurfer instance
                         */
                        function WaveSurfer(params) {
                            var _this;

                            _classCallCheck(this, WaveSurfer);

                            _this = _possibleConstructorReturn(this, _getPrototypeOf(WaveSurfer).call(this));
                            /**
                             * Extract relevant parameters (or defaults)
                             * @private
                             */

                            _this.defaultParams = {
                                audioContext: null,
                                audioScriptProcessor: null,
                                audioRate: 1,
                                autoCenter: true,
                                autoCenterRate: 5,
                                autoCenterImmediately: false,
                                backend: 'WebAudio',
                                backgroundColor: null,
                                barHeight: 1,
                                barRadius: 0,
                                barGap: null,
                                barMinHeight: null,
                                container: null,
                                cursorColor: '#333',
                                cursorWidth: 1,
                                dragSelection: true,
                                drawingContextAttributes: {
                                    // Boolean that hints the user agent to reduce the latency
                                    // by desynchronizing the canvas paint cycle from the event
                                    // loop
                                    desynchronized: false
                                },
                                duration: null,
                                fillParent: true,
                                forceDecode: false,
                                height: 128,
                                hideScrollbar: false,
                                interact: true,
                                loopSelection: true,
                                maxCanvasWidth: 4000,
                                mediaContainer: null,
                                mediaControls: false,
                                mediaType: 'audio',
                                minPxPerSec: 20,
                                normalize: false,
                                partialRender: false,
                                pixelRatio: window.devicePixelRatio || screen.deviceXDPI / screen.logicalXDPI,
                                plugins: [],
                                progressColor: '#555',
                                removeMediaElementOnDestroy: true,
                                renderer: _drawer.default,
                                responsive: false,
                                rtl: false,
                                scrollParent: false,
                                skipLength: 2,
                                splitChannels: false,
                                splitChannelsOptions: {
                                    overlay: false,
                                    channelColors: {},
                                    filterChannels: []
                                },
                                waveColor: '#999',
                                xhr: {}
                            };
                            _this.backends = {
                                MediaElement: _mediaelement.default,
                                WebAudio: _webaudio.default,
                                MediaElementWebAudio: _mediaelementWebaudio.default
                            };
                            _this.util = util;
                            _this.params = Object.assign({}, _this.defaultParams, params);
                            /** @private */

                            _this.container = 'string' == typeof params.container ? document.querySelector(_this.params.container) : _this.params.container;

                            if (!_this.container) {
                                throw new Error('Container element not found');
                            }

                            if (_this.params.mediaContainer == null) {
                                /** @private */
                                _this.mediaContainer = _this.container;
                            } else if (typeof _this.params.mediaContainer == 'string') {
                                /** @private */
                                _this.mediaContainer = document.querySelector(_this.params.mediaContainer);
                            } else {
                                /** @private */
                                _this.mediaContainer = _this.params.mediaContainer;
                            }

                            if (!_this.mediaContainer) {
                                throw new Error('Media Container element not found');
                            }

                            if (_this.params.maxCanvasWidth <= 1) {
                                throw new Error('maxCanvasWidth must be greater than 1');
                            } else if (_this.params.maxCanvasWidth % 2 == 1) {
                                throw new Error('maxCanvasWidth must be an even number');
                            }

                            if (_this.params.rtl === true) {
                                util.style(_this.container, {
                                    transform: 'rotateY(180deg)'
                                });
                            }

                            if (_this.params.backgroundColor) {
                                _this.setBackgroundColor(_this.params.backgroundColor);
                            }
                            /**
                             * @private Used to save the current volume when muting so we can
                             * restore once unmuted
                             * @type {number}
                             */


                            _this.savedVolume = 0;
                            /**
                             * @private The current muted state
                             * @type {boolean}
                             */

                            _this.isMuted = false;
                            /**
                             * @private Will hold a list of event descriptors that need to be
                             * canceled on subsequent loads of audio
                             * @type {Object[]}
                             */

                            _this.tmpEvents = [];
                            /**
                             * @private Holds any running audio downloads
                             * @type {Observer}
                             */

                            _this.currentRequest = null;
                            /** @private */

                            _this.arraybuffer = null;
                            /** @private */

                            _this.drawer = null;
                            /** @private */

                            _this.backend = null;
                            /** @private */

                            _this.peakCache = null; // cache constructor objects

                            if (typeof _this.params.renderer !== 'function') {
                                throw new Error('Renderer parameter is invalid');
                            }
                            /**
                             * @private The uninitialised Drawer class
                             */


                            _this.Drawer = _this.params.renderer;
                            /**
                             * @private The uninitialised Backend class
                             */
                            // Back compat

                            if (_this.params.backend == 'AudioElement') {
                                _this.params.backend = 'MediaElement';
                            }

                            if ((_this.params.backend == 'WebAudio' || _this.params.backend === 'MediaElementWebAudio') && !_webaudio.default.prototype.supportsWebAudio.call(null)) {
                                _this.params.backend = 'MediaElement';
                            }

                            _this.Backend = _this.backends[_this.params.backend];
                            /**
                             * @private map of plugin names that are currently initialised
                             */

                            _this.initialisedPluginList = {};
                            /** @private */

                            _this.isDestroyed = false;
                            /**
                             * Get the current ready status.
                             *
                             * @example const isReady = wavesurfer.isReady;
                             * @return {boolean}
                             */

                            _this.isReady = false; // responsive debounced event listener. If this.params.responsive is not
                            // set, this is never called. Use 100ms or this.params.responsive as
                            // timeout for the debounce function.

                            var prevWidth = 0;
                            _this._onResize = util.debounce(function () {
                                if (prevWidth != _this.drawer.wrapper.clientWidth && !_this.params.scrollParent) {
                                    prevWidth = _this.drawer.wrapper.clientWidth;

                                    _this.drawer.fireEvent('redraw');
                                }
                            }, typeof _this.params.responsive === 'number' ? _this.params.responsive : 100);
                            return _possibleConstructorReturn(_this, _assertThisInitialized(_this));
                        }

                        /**
                         * Initialise the wave
                         *
                         * @example
                         * var wavesurfer = new WaveSurfer(params);
                         * wavesurfer.init();
                         * @return {this} The wavesurfer instance
                         */


                        _createClass(WaveSurfer, [{
                            key: "init",
                            value: function init() {
                                this.registerPlugins(this.params.plugins);
                                this.createDrawer();
                                this.createBackend();
                                this.createPeakCache();
                                return this;
                            }
                            /**
                             * Add and initialise array of plugins (if `plugin.deferInit` is falsey),
                             * this function is called in the init function of wavesurfer
                             *
                             * @param {PluginDefinition[]} plugins An array of plugin definitions
                             * @emits {WaveSurfer#plugins-registered} Called with the array of plugin definitions
                             * @return {this} The wavesurfer instance
                             */

                        }, {
                            key: "registerPlugins",
                            value: function registerPlugins(plugins) {
                                var _this2 = this;

                                // first instantiate all the plugins
                                plugins.forEach(function (plugin) {
                                    return _this2.addPlugin(plugin);
                                }); // now run the init functions

                                plugins.forEach(function (plugin) {
                                    // call init function of the plugin if deferInit is falsey
                                    // in that case you would manually use initPlugins()
                                    if (!plugin.deferInit) {
                                        _this2.initPlugin(plugin.name);
                                    }
                                });
                                this.fireEvent('plugins-registered', plugins);
                                return this;
                            }
                            /**
                             * Get a map of plugin names that are currently initialised
                             *
                             * @example wavesurfer.getPlugins();
                             * @return {Object} Object with plugin names
                             */

                        }, {
                            key: "getActivePlugins",
                            value: function getActivePlugins() {
                                return this.initialisedPluginList;
                            }
                            /**
                             * Add a plugin object to wavesurfer
                             *
                             * @param {PluginDefinition} plugin A plugin definition
                             * @emits {WaveSurfer#plugin-added} Called with the name of the plugin that was added
                             * @example wavesurfer.addPlugin(WaveSurfer.minimap());
                             * @return {this} The wavesurfer instance
                             */

                        }, {
                            key: "addPlugin",
                            value: function addPlugin(plugin) {
                                var _this3 = this;

                                if (!plugin.name) {
                                    throw new Error('Plugin does not have a name!');
                                }

                                if (!plugin.instance) {
                                    throw new Error("Plugin ".concat(plugin.name, " does not have an instance property!"));
                                } // staticProps properties are applied to wavesurfer instance


                                if (plugin.staticProps) {
                                    Object.keys(plugin.staticProps).forEach(function (pluginStaticProp) {
                                        /**
                                         * Properties defined in a plugin definition's `staticProps` property are added as
                                         * staticProps properties of the WaveSurfer instance
                                         */
                                        _this3[pluginStaticProp] = plugin.staticProps[pluginStaticProp];
                                    });
                                }

                                var Instance = plugin.instance; // turn the plugin instance into an observer

                                var observerPrototypeKeys = Object.getOwnPropertyNames(util.Observer.prototype);
                                observerPrototypeKeys.forEach(function (key) {
                                    Instance.prototype[key] = util.Observer.prototype[key];
                                });
                                /**
                                 * Instantiated plugin classes are added as a property of the wavesurfer
                                 * instance
                                 * @type {Object}
                                 */

                                this[plugin.name] = new Instance(plugin.params || {}, this);
                                this.fireEvent('plugin-added', plugin.name);
                                return this;
                            }
                            /**
                             * Initialise a plugin
                             *
                             * @param {string} name A plugin name
                             * @emits WaveSurfer#plugin-initialised
                             * @example wavesurfer.initPlugin('minimap');
                             * @return {this} The wavesurfer instance
                             */

                        }, {
                            key: "initPlugin",
                            value: function initPlugin(name) {
                                if (!this[name]) {
                                    throw new Error("Plugin ".concat(name, " has not been added yet!"));
                                }

                                if (this.initialisedPluginList[name]) {
                                    // destroy any already initialised plugins
                                    this.destroyPlugin(name);
                                }

                                this[name].init();
                                this.initialisedPluginList[name] = true;
                                this.fireEvent('plugin-initialised', name);
                                return this;
                            }
                            /**
                             * Destroy a plugin
                             *
                             * @param {string} name A plugin name
                             * @emits WaveSurfer#plugin-destroyed
                             * @example wavesurfer.destroyPlugin('minimap');
                             * @returns {this} The wavesurfer instance
                             */

                        }, {
                            key: "destroyPlugin",
                            value: function destroyPlugin(name) {
                                if (!this[name]) {
                                    throw new Error("Plugin ".concat(name, " has not been added yet and cannot be destroyed!"));
                                }

                                if (!this.initialisedPluginList[name]) {
                                    throw new Error("Plugin ".concat(name, " is not active and cannot be destroyed!"));
                                }

                                if (typeof this[name].destroy !== 'function') {
                                    throw new Error("Plugin ".concat(name, " does not have a destroy function!"));
                                }

                                this[name].destroy();
                                delete this.initialisedPluginList[name];
                                this.fireEvent('plugin-destroyed', name);
                                return this;
                            }
                            /**
                             * Destroy all initialised plugins. Convenience function to use when
                             * wavesurfer is removed
                             *
                             * @private
                             */

                        }, {
                            key: "destroyAllPlugins",
                            value: function destroyAllPlugins() {
                                var _this4 = this;

                                Object.keys(this.initialisedPluginList).forEach(function (name) {
                                    return _this4.destroyPlugin(name);
                                });
                            }
                            /**
                             * Create the drawer and draw the waveform
                             *
                             * @private
                             * @emits WaveSurfer#drawer-created
                             */

                        }, {
                            key: "createDrawer",
                            value: function createDrawer() {
                                var _this5 = this;

                                this.drawer = new this.Drawer(this.container, this.params);
                                this.drawer.init();
                                this.fireEvent('drawer-created', this.drawer);

                                if (this.params.responsive !== false) {
                                    window.addEventListener('resize', this._onResize, true);
                                    window.addEventListener('orientationchange', this._onResize, true);
                                }

                                this.drawer.on('redraw', function () {
                                    _this5.drawBuffer();

                                    _this5.drawer.progress(_this5.backend.getPlayedPercents());
                                }); // Click-to-seek

                                this.drawer.on('click', function (e, progress) {
                                    setTimeout(function () {
                                        return _this5.seekTo(progress);
                                    }, 0);
                                }); // Relay the scroll event from the drawer

                                this.drawer.on('scroll', function (e) {
                                    if (_this5.params.partialRender) {
                                        _this5.drawBuffer();
                                    }

                                    _this5.fireEvent('scroll', e);
                                });
                            }
                            /**
                             * Create the backend
                             *
                             * @private
                             * @emits WaveSurfer#backend-created
                             */

                        }, {
                            key: "createBackend",
                            value: function createBackend() {
                                var _this6 = this;

                                if (this.backend) {
                                    this.backend.destroy();
                                }

                                this.backend = new this.Backend(this.params);
                                this.backend.init();
                                this.fireEvent('backend-created', this.backend);
                                this.backend.on('finish', function () {
                                    _this6.drawer.progress(_this6.backend.getPlayedPercents());

                                    _this6.fireEvent('finish');
                                });
                                this.backend.on('play', function () {
                                    return _this6.fireEvent('play');
                                });
                                this.backend.on('pause', function () {
                                    return _this6.fireEvent('pause');
                                });
                                this.backend.on('audioprocess', function (time) {
                                    _this6.drawer.progress(_this6.backend.getPlayedPercents());

                                    _this6.fireEvent('audioprocess', time);
                                }); // only needed for MediaElement and MediaElementWebAudio backend

                                if (this.params.backend === 'MediaElement' || this.params.backend === 'MediaElementWebAudio') {
                                    this.backend.on('seek', function () {
                                        _this6.drawer.progress(_this6.backend.getPlayedPercents());
                                    });
                                    this.backend.on('volume', function () {
                                        var newVolume = _this6.getVolume();

                                        _this6.fireEvent('volume', newVolume);

                                        if (_this6.backend.isMuted !== _this6.isMuted) {
                                            _this6.isMuted = _this6.backend.isMuted;

                                            _this6.fireEvent('mute', _this6.isMuted);
                                        }
                                    });
                                }
                            }
                            /**
                             * Create the peak cache
                             *
                             * @private
                             */

                        }, {
                            key: "createPeakCache",
                            value: function createPeakCache() {
                                if (this.params.partialRender) {
                                    this.peakCache = new _peakcache.default();
                                }
                            }
                            /**
                             * Get the duration of the audio clip
                             *
                             * @example const duration = wavesurfer.getDuration();
                             * @return {number} Duration in seconds
                             */

                        }, {
                            key: "getDuration",
                            value: function getDuration() {
                                return this.backend.getDuration();
                            }
                            /**
                             * Get the current playback position
                             *
                             * @example const currentTime = wavesurfer.getCurrentTime();
                             * @return {number} Playback position in seconds
                             */

                        }, {
                            key: "getCurrentTime",
                            value: function getCurrentTime() {
                                return this.backend.getCurrentTime();
                            }
                            /**
                             * Set the current play time in seconds.
                             *
                             * @param {number} seconds A positive number in seconds. E.g. 10 means 10
                             * seconds, 60 means 1 minute
                             */

                        }, {
                            key: "setCurrentTime",
                            value: function setCurrentTime(seconds) {
                                if (seconds >= this.getDuration()) {
                                    this.seekTo(1);
                                } else {
                                    this.seekTo(seconds / this.getDuration());
                                }
                            }
                            /**
                             * Starts playback from the current position. Optional start and end
                             * measured in seconds can be used to set the range of audio to play.
                             *
                             * @param {?number} start Position to start at
                             * @param {?number} end Position to end at
                             * @emits WaveSurfer#interaction
                             * @return {Promise} Result of the backend play method
                             * @example
                             * // play from second 1 to 5
                             * wavesurfer.play(1, 5);
                             */

                        }, {
                            key: "play",
                            value: function play(start, end) {
                                var _this7 = this;

                                this.fireEvent('interaction', function () {
                                    return _this7.play(start, end);
                                });
                                return this.backend.play(start, end);
                            }
                            /**
                             * Set a point in seconds for playback to stop at.
                             *
                             * @param {number} position Position (in seconds) to stop at
                             * @version 3.3.0
                             */

                        }, {
                            key: "setPlayEnd",
                            value: function setPlayEnd(position) {
                                this.backend.setPlayEnd(position);
                            }
                            /**
                             * Stops and pauses playback
                             *
                             * @example wavesurfer.pause();
                             * @return {Promise} Result of the backend pause method
                             */

                        }, {
                            key: "pause",
                            value: function pause() {
                                if (!this.backend.isPaused()) {
                                    return this.backend.pause();
                                }
                            }
                            /**
                             * Toggle playback
                             *
                             * @example wavesurfer.playPause();
                             * @return {Promise} Result of the backend play or pause method
                             */

                        }, {
                            key: "playPause",
                            value: function playPause() {
                                return this.backend.isPaused() ? this.play() : this.pause();
                            }
                            /**
                             * Get the current playback state
                             *
                             * @example const isPlaying = wavesurfer.isPlaying();
                             * @return {boolean} False if paused, true if playing
                             */

                        }, {
                            key: "isPlaying",
                            value: function isPlaying() {
                                return !this.backend.isPaused();
                            }
                            /**
                             * Skip backward
                             *
                             * @param {?number} seconds Amount to skip back, if not specified `skipLength`
                             * is used
                             * @example wavesurfer.skipBackward();
                             */

                        }, {
                            key: "skipBackward",
                            value: function skipBackward(seconds) {
                                this.skip(-seconds || -this.params.skipLength);
                            }
                            /**
                             * Skip forward
                             *
                             * @param {?number} seconds Amount to skip back, if not specified `skipLength`
                             * is used
                             * @example wavesurfer.skipForward();
                             */

                        }, {
                            key: "skipForward",
                            value: function skipForward(seconds) {
                                this.skip(seconds || this.params.skipLength);
                            }
                            /**
                             * Skip a number of seconds from the current position (use a negative value
                             * to go backwards).
                             *
                             * @param {number} offset Amount to skip back or forwards
                             * @example
                             * // go back 2 seconds
                             * wavesurfer.skip(-2);
                             */

                        }, {
                            key: "skip",
                            value: function skip(offset) {
                                var duration = this.getDuration() || 1;
                                var position = this.getCurrentTime() || 0;
                                position = Math.max(0, Math.min(duration, position + (offset || 0)));
                                this.seekAndCenter(position / duration);
                            }
                            /**
                             * Seeks to a position and centers the view
                             *
                             * @param {number} progress Between 0 (=beginning) and 1 (=end)
                             * @example
                             * // seek and go to the middle of the audio
                             * wavesurfer.seekTo(0.5);
                             */

                        }, {
                            key: "seekAndCenter",
                            value: function seekAndCenter(progress) {
                                this.seekTo(progress);
                                this.drawer.recenter(progress);
                            }
                            /**
                             * Seeks to a position
                             *
                             * @param {number} progress Between 0 (=beginning) and 1 (=end)
                             * @emits WaveSurfer#interaction
                             * @emits WaveSurfer#seek
                             * @example
                             * // seek to the middle of the audio
                             * wavesurfer.seekTo(0.5);
                             */

                        }, {
                            key: "seekTo",
                            value: function seekTo(progress) {
                                var _this8 = this;

                                // return an error if progress is not a number between 0 and 1
                                if (typeof progress !== 'number' || !isFinite(progress) || progress < 0 || progress > 1) {
                                    throw new Error('Error calling wavesurfer.seekTo, parameter must be a number between 0 and 1!');
                                }

                                this.fireEvent('interaction', function () {
                                    return _this8.seekTo(progress);
                                });
                                var paused = this.backend.isPaused(); // avoid draw wrong position while playing backward seeking

                                if (!paused) {
                                    this.backend.pause();
                                } // avoid small scrolls while paused seeking


                                var oldScrollParent = this.params.scrollParent;
                                this.params.scrollParent = false;
                                this.backend.seekTo(progress * this.getDuration());
                                this.drawer.progress(progress);

                                if (!paused) {
                                    this.backend.play();
                                }

                                this.params.scrollParent = oldScrollParent;
                                this.fireEvent('seek', progress);
                            }
                            /**
                             * Stops and goes to the beginning.
                             *
                             * @example wavesurfer.stop();
                             */

                        }, {
                            key: "stop",
                            value: function stop() {
                                this.pause();
                                this.seekTo(0);
                                this.drawer.progress(0);
                            }
                            /**
                             * Sets the ID of the audio device to use for output and returns a Promise.
                             *
                             * @param {string} deviceId String value representing underlying output
                             * device
                             * @returns {Promise} `Promise` that resolves to `undefined` when there are
                             * no errors detected.
                             */

                        }, {
                            key: "setSinkId",
                            value: function setSinkId(deviceId) {
                                return this.backend.setSinkId(deviceId);
                            }
                            /**
                             * Set the playback volume.
                             *
                             * @param {number} newVolume A value between 0 and 1, 0 being no
                             * volume and 1 being full volume.
                             * @emits WaveSurfer#volume
                             */

                        }, {
                            key: "setVolume",
                            value: function setVolume(newVolume) {
                                this.backend.setVolume(newVolume);
                                this.fireEvent('volume', newVolume);
                            }
                            /**
                             * Get the playback volume.
                             *
                             * @return {number} A value between 0 and 1, 0 being no
                             * volume and 1 being full volume.
                             */

                        }, {
                            key: "getVolume",
                            value: function getVolume() {
                                return this.backend.getVolume();
                            }
                            /**
                             * Set the playback rate.
                             *
                             * @param {number} rate A positive number. E.g. 0.5 means half the normal
                             * speed, 2 means double speed and so on.
                             * @example wavesurfer.setPlaybackRate(2);
                             */

                        }, {
                            key: "setPlaybackRate",
                            value: function setPlaybackRate(rate) {
                                this.backend.setPlaybackRate(rate);
                            }
                            /**
                             * Get the playback rate.
                             *
                             * @return {number} The current playback rate.
                             */

                        }, {
                            key: "getPlaybackRate",
                            value: function getPlaybackRate() {
                                return this.backend.getPlaybackRate();
                            }
                            /**
                             * Toggle the volume on and off. If not currently muted it will save the
                             * current volume value and turn the volume off. If currently muted then it
                             * will restore the volume to the saved value, and then rest the saved
                             * value.
                             *
                             * @example wavesurfer.toggleMute();
                             */

                        }, {
                            key: "toggleMute",
                            value: function toggleMute() {
                                this.setMute(!this.isMuted);
                            }
                            /**
                             * Enable or disable muted audio
                             *
                             * @param {boolean} mute Specify `true` to mute audio.
                             * @emits WaveSurfer#volume
                             * @emits WaveSurfer#mute
                             * @example
                             * // unmute
                             * wavesurfer.setMute(false);
                             * console.log(wavesurfer.getMute()) // logs false
                             */

                        }, {
                            key: "setMute",
                            value: function setMute(mute) {
                                // ignore all muting requests if the audio is already in that state
                                if (mute === this.isMuted) {
                                    this.fireEvent('mute', this.isMuted);
                                    return;
                                }

                                if (this.backend.setMute) {
                                    // Backends such as the MediaElement backend have their own handling
                                    // of mute, let them handle it.
                                    this.backend.setMute(mute);
                                    this.isMuted = mute;
                                } else {
                                    if (mute) {
                                        // If currently not muted then save current volume,
                                        // turn off the volume and update the mute properties
                                        this.savedVolume = this.backend.getVolume();
                                        this.backend.setVolume(0);
                                        this.isMuted = true;
                                        this.fireEvent('volume', 0);
                                    } else {
                                        // If currently muted then restore to the saved volume
                                        // and update the mute properties
                                        this.backend.setVolume(this.savedVolume);
                                        this.isMuted = false;
                                        this.fireEvent('volume', this.savedVolume);
                                    }
                                }

                                this.fireEvent('mute', this.isMuted);
                            }
                            /**
                             * Get the current mute status.
                             *
                             * @example const isMuted = wavesurfer.getMute();
                             * @return {boolean} Current mute status
                             */

                        }, {
                            key: "getMute",
                            value: function getMute() {
                                return this.isMuted;
                            }
                            /**
                             * Get the list of current set filters as an array.
                             *
                             * Filters must be set with setFilters method first
                             *
                             * @return {array} List of enabled filters
                             */

                        }, {
                            key: "getFilters",
                            value: function getFilters() {
                                return this.backend.filters || [];
                            }
                            /**
                             * Toggles `scrollParent` and redraws
                             *
                             * @example wavesurfer.toggleScroll();
                             */

                        }, {
                            key: "toggleScroll",
                            value: function toggleScroll() {
                                this.params.scrollParent = !this.params.scrollParent;
                                this.drawBuffer();
                            }
                            /**
                             * Toggle mouse interaction
                             *
                             * @example wavesurfer.toggleInteraction();
                             */

                        }, {
                            key: "toggleInteraction",
                            value: function toggleInteraction() {
                                this.params.interact = !this.params.interact;
                            }
                            /**
                             * Get the fill color of the waveform after the cursor.
                             *
                             * @return {string} A CSS color string.
                             */

                        }, {
                            key: "getWaveColor",
                            value: function getWaveColor() {
                                return this.params.waveColor;
                            }
                            /**
                             * Set the fill color of the waveform after the cursor.
                             *
                             * @param {string} color A CSS color string.
                             * @example wavesurfer.setWaveColor('#ddd');
                             */

                        }, {
                            key: "setWaveColor",
                            value: function setWaveColor(color) {
                                this.params.waveColor = color;
                                this.drawBuffer();
                            }
                            /**
                             * Get the fill color of the waveform behind the cursor.
                             *
                             * @return {string} A CSS color string.
                             */

                        }, {
                            key: "getProgressColor",
                            value: function getProgressColor() {
                                return this.params.progressColor;
                            }
                            /**
                             * Set the fill color of the waveform behind the cursor.
                             *
                             * @param {string} color A CSS color string.
                             * @example wavesurfer.setProgressColor('#400');
                             */

                        }, {
                            key: "setProgressColor",
                            value: function setProgressColor(color) {
                                this.params.progressColor = color;
                                this.drawBuffer();
                            }
                            /**
                             * Get the background color of the waveform container.
                             *
                             * @return {string} A CSS color string.
                             */

                        }, {
                            key: "getBackgroundColor",
                            value: function getBackgroundColor() {
                                return this.params.backgroundColor;
                            }
                            /**
                             * Set the background color of the waveform container.
                             *
                             * @param {string} color A CSS color string.
                             * @example wavesurfer.setBackgroundColor('#FF00FF');
                             */

                        }, {
                            key: "setBackgroundColor",
                            value: function setBackgroundColor(color) {
                                this.params.backgroundColor = color;
                                util.style(this.container, {
                                    background: this.params.backgroundColor
                                });
                            }
                            /**
                             * Get the fill color of the cursor indicating the playhead
                             * position.
                             *
                             * @return {string} A CSS color string.
                             */

                        }, {
                            key: "getCursorColor",
                            value: function getCursorColor() {
                                return this.params.cursorColor;
                            }
                            /**
                             * Set the fill color of the cursor indicating the playhead
                             * position.
                             *
                             * @param {string} color A CSS color string.
                             * @example wavesurfer.setCursorColor('#222');
                             */

                        }, {
                            key: "setCursorColor",
                            value: function setCursorColor(color) {
                                this.params.cursorColor = color;
                                this.drawer.updateCursor();
                            }
                            /**
                             * Get the height of the waveform.
                             *
                             * @return {number} Height measured in pixels.
                             */

                        }, {
                            key: "getHeight",
                            value: function getHeight() {
                                return this.params.height;
                            }
                            /**
                             * Set the height of the waveform.
                             *
                             * @param {number} height Height measured in pixels.
                             * @example wavesurfer.setHeight(200);
                             */

                        }, {
                            key: "setHeight",
                            value: function setHeight(height) {
                                this.params.height = height;
                                this.drawer.setHeight(height * this.params.pixelRatio);
                                this.drawBuffer();
                            }
                            /**
                             * Hide channels from being drawn on the waveform if splitting channels.
                             *
                             * For example, if we want to draw only the peaks for the right stereo channel:
                             *
                             * const wavesurfer = new WaveSurfer.create({...splitChannels: true});
                             * wavesurfer.load('stereo_audio.mp3');
                             *
                             * wavesurfer.setFilteredChannel([0]); <-- hide left channel peaks.
                             *
                             * @param {array} channelIndices Channels to be filtered out from drawing.
                             * @version 4.0.0
                             */

                        }, {
                            key: "setFilteredChannels",
                            value: function setFilteredChannels(channelIndices) {
                                this.params.splitChannelsOptions.filterChannels = channelIndices;
                                this.drawBuffer();
                            }
                            /**
                             * Get the correct peaks for current wave view-port and render wave
                             *
                             * @private
                             * @emits WaveSurfer#redraw
                             */

                        }, {
                            key: "drawBuffer",
                            value: function drawBuffer() {
                                var nominalWidth = Math.round(this.getDuration() * this.params.minPxPerSec * this.params.pixelRatio);
                                var parentWidth = this.drawer.getWidth();
                                var width = nominalWidth; // always start at 0 after zooming for scrolling : issue redraw left part

                                var start = 0;
                                var end = Math.max(start + parentWidth, width); // Fill container

                                if (this.params.fillParent && (!this.params.scrollParent || nominalWidth < parentWidth)) {
                                    width = parentWidth;
                                    start = 0;
                                    end = width;
                                }

                                var peaks;

                                if (this.params.partialRender) {
                                    var newRanges = this.peakCache.addRangeToPeakCache(width, start, end);
                                    var i;

                                    for (i = 0; i < newRanges.length; i++) {
                                        peaks = this.backend.getPeaks(width, newRanges[i][0], newRanges[i][1]);
                                        this.drawer.drawPeaks(peaks, width, newRanges[i][0], newRanges[i][1]);
                                    }
                                } else {
                                    peaks = this.backend.getPeaks(width, start, end);
                                    this.drawer.drawPeaks(peaks, width, start, end);
                                }

                                this.fireEvent('redraw', peaks, width);
                            }
                            /**
                             * Horizontally zooms the waveform in and out. It also changes the parameter
                             * `minPxPerSec` and enables the `scrollParent` option. Calling the function
                             * with a falsey parameter will reset the zoom state.
                             *
                             * @param {?number} pxPerSec Number of horizontal pixels per second of
                             * audio, if none is set the waveform returns to unzoomed state
                             * @emits WaveSurfer#zoom
                             * @example wavesurfer.zoom(20);
                             */

                        }, {
                            key: "zoom",
                            value: function zoom(pxPerSec) {
                                if (!pxPerSec) {
                                    this.params.minPxPerSec = this.defaultParams.minPxPerSec;
                                    this.params.scrollParent = false;
                                } else {
                                    this.params.minPxPerSec = pxPerSec;
                                    this.params.scrollParent = true;
                                }

                                this.drawBuffer();
                                this.drawer.progress(this.backend.getPlayedPercents());
                                this.drawer.recenter(this.getCurrentTime() / this.getDuration());
                                this.fireEvent('zoom', pxPerSec);
                            }
                            /**
                             * Decode buffer and load
                             *
                             * @private
                             * @param {ArrayBuffer} arraybuffer Buffer to process
                             */

                        }, {
                            key: "loadArrayBuffer",
                            value: function loadArrayBuffer(arraybuffer) {
                                var _this9 = this;

                                this.decodeArrayBuffer(arraybuffer, function (data) {
                                    if (!_this9.isDestroyed) {
                                        _this9.loadDecodedBuffer(data);
                                    }
                                });
                            }
                            /**
                             * Directly load an externally decoded AudioBuffer
                             *
                             * @private
                             * @param {AudioBuffer} buffer Buffer to process
                             * @emits WaveSurfer#ready
                             */

                        }, {
                            key: "loadDecodedBuffer",
                            value: function loadDecodedBuffer(buffer) {
                                this.backend.load(buffer);
                                this.drawBuffer();
                                this.isReady = true;
                                this.fireEvent('ready');
                            }
                            /**
                             * Loads audio data from a Blob or File object
                             *
                             * @param {Blob|File} blob Audio data
                             * @example
                             */

                        }, {
                            key: "loadBlob",
                            value: function loadBlob(blob) {
                                var _this10 = this;

                                // Create file reader
                                var reader = new FileReader();
                                reader.addEventListener('progress', function (e) {
                                    return _this10.onProgress(e);
                                });
                                reader.addEventListener('load', function (e) {
                                    return _this10.loadArrayBuffer(e.target.result);
                                });
                                reader.addEventListener('error', function () {
                                    return _this10.fireEvent('error', 'Error reading file');
                                });
                                reader.readAsArrayBuffer(blob);
                                this.empty();
                            }
                            /**
                             * Loads audio and re-renders the waveform.
                             *
                             * @param {string|HTMLMediaElement} url The url of the audio file or the
                             * audio element with the audio
                             * @param {number[]|Number.<Array[]>} peaks Wavesurfer does not have to decode
                             * the audio to render the waveform if this is specified
                             * @param {?string} preload (Use with backend `MediaElement` and `MediaElementWebAudio`)
                             * `'none'|'metadata'|'auto'` Preload attribute for the media element
                             * @param {?number} duration The duration of the audio. This is used to
                             * render the peaks data in the correct size for the audio duration (as
                             * befits the current `minPxPerSec` and zoom value) without having to decode
                             * the audio.
                             * @returns {void}
                             * @throws Will throw an error if the `url` argument is empty.
                             * @example
                             * // uses fetch or media element to load file (depending on backend)
                             * wavesurfer.load('http://example.com/demo.wav');
                             *
                             * // setting preload attribute with media element backend and supplying
                             * // peaks
                             * wavesurfer.load(
                             *   'http://example.com/demo.wav',
                             *   [0.0218, 0.0183, 0.0165, 0.0198, 0.2137, 0.2888],
                             *   true
                             * );
                             */

                        }, {
                            key: "load",
                            value: function load(url, peaks, preload, duration) {
                                if (!url) {
                                    throw new Error('url parameter cannot be empty');
                                }

                                this.empty();

                                if (preload) {
                                    // check whether the preload attribute will be usable and if not log
                                    // a warning listing the reasons why not and nullify the variable
                                    var preloadIgnoreReasons = {
                                        "Preload is not 'auto', 'none' or 'metadata'": ['auto', 'metadata', 'none'].indexOf(preload) === -1,
                                        'Peaks are not provided': !peaks,
                                        "Backend is not of type 'MediaElement' or 'MediaElementWebAudio'": ['MediaElement', 'MediaElementWebAudio'].indexOf(this.params.backend) === -1,
                                        'Url is not of type string': typeof url !== 'string'
                                    };
                                    var activeReasons = Object.keys(preloadIgnoreReasons).filter(function (reason) {
                                        return preloadIgnoreReasons[reason];
                                    });

                                    if (activeReasons.length) {
                                        // eslint-disable-next-line no-console
                                        console.warn('Preload parameter of wavesurfer.load will be ignored because:\n\t- ' + activeReasons.join('\n\t- ')); // stop invalid values from being used

                                        preload = null;
                                    }
                                }

                                switch (this.params.backend) {
                                    case 'WebAudio':
                                        return this.loadBuffer(url, peaks, duration);

                                    case 'MediaElement':
                                    case 'MediaElementWebAudio':
                                        return this.loadMediaElement(url, peaks, preload, duration);
                                }
                            }
                            /**
                             * Loads audio using Web Audio buffer backend.
                             *
                             * @private
                             * @param {string} url URL of audio file
                             * @param {number[]|Number.<Array[]>} peaks Peaks data
                             * @param {?number} duration Optional duration of audio file
                             * @returns {void}
                             */

                        }, {
                            key: "loadBuffer",
                            value: function loadBuffer(url, peaks, duration) {
                                var _this11 = this;

                                var load = function load(action) {
                                    if (action) {
                                        _this11.tmpEvents.push(_this11.once('ready', action));
                                    }

                                    return _this11.getArrayBuffer(url, function (data) {
                                        return _this11.loadArrayBuffer(data);
                                    });
                                };

                                if (peaks) {
                                    this.backend.setPeaks(peaks, duration);
                                    this.drawBuffer();
                                    this.tmpEvents.push(this.once('interaction', load));
                                } else {
                                    return load();
                                }
                            }
                            /**
                             * Either create a media element, or load an existing media element.
                             *
                             * @private
                             * @param {string|HTMLMediaElement} urlOrElt Either a path to a media file, or an
                             * existing HTML5 Audio/Video Element
                             * @param {number[]|Number.<Array[]>} peaks Array of peaks. Required to bypass web audio
                             * dependency
                             * @param {?boolean} preload Set to true if the preload attribute of the
                             * audio element should be enabled
                             * @param {?number} duration Optional duration of audio file
                             */

                        }, {
                            key: "loadMediaElement",
                            value: function loadMediaElement(urlOrElt, peaks, preload, duration) {
                                var _this12 = this;

                                var url = urlOrElt;

                                if (typeof urlOrElt === 'string') {
                                    this.backend.load(url, this.mediaContainer, peaks, preload);
                                } else {
                                    var elt = urlOrElt;
                                    this.backend.loadElt(elt, peaks); // If peaks are not provided,
                                    // url = element.src so we can get peaks with web audio

                                    url = elt.src;
                                }

                                this.tmpEvents.push(this.backend.once('canplay', function () {
                                    // ignore when backend was already destroyed
                                    if (!_this12.backend.destroyed) {
                                        _this12.drawBuffer();

                                        _this12.isReady = true;

                                        _this12.fireEvent('ready');
                                    }
                                }), this.backend.once('error', function (err) {
                                    return _this12.fireEvent('error', err);
                                })); // If no pre-decoded peaks provided or pre-decoded peaks are
                                // provided with forceDecode flag, attempt to download the
                                // audio file and decode it with Web Audio.

                                if (peaks) {
                                    this.backend.setPeaks(peaks, duration);
                                }

                                if ((!peaks || this.params.forceDecode) && this.backend.supportsWebAudio()) {
                                    this.getArrayBuffer(url, function (arraybuffer) {
                                        _this12.decodeArrayBuffer(arraybuffer, function (buffer) {
                                            _this12.backend.buffer = buffer;

                                            _this12.backend.setPeaks(null);

                                            _this12.drawBuffer();

                                            _this12.fireEvent('waveform-ready');
                                        });
                                    });
                                }
                            }
                            /**
                             * Decode an array buffer and pass data to a callback
                             *
                             * @private
                             * @param {Object} arraybuffer The array buffer to decode
                             * @param {function} callback The function to call on complete
                             */

                        }, {
                            key: "decodeArrayBuffer",
                            value: function decodeArrayBuffer(arraybuffer, callback) {
                                var _this13 = this;

                                this.arraybuffer = arraybuffer;
                                this.backend.decodeArrayBuffer(arraybuffer, function (data) {
                                    // Only use the decoded data if we haven't been destroyed or
                                    // another decode started in the meantime
                                    if (!_this13.isDestroyed && _this13.arraybuffer == arraybuffer) {
                                        callback(data);
                                        _this13.arraybuffer = null;
                                    }
                                }, function () {
                                    return _this13.fireEvent('error', 'Error decoding audiobuffer');
                                });
                            }
                            /**
                             * Load an array buffer using fetch and pass the result to a callback
                             *
                             * @param {string} url The URL of the file object
                             * @param {function} callback The function to call on complete
                             * @returns {util.fetchFile} fetch call
                             * @private
                             */

                        }, {
                            key: "getArrayBuffer",
                            value: function getArrayBuffer(url, callback) {
                                var _this14 = this;

                                var options = Object.assign({
                                    url: url,
                                    responseType: 'arraybuffer'
                                }, this.params.xhr);
                                var request = util.fetchFile(options);
                                this.currentRequest = request;
                                this.tmpEvents.push(request.on('progress', function (e) {
                                    _this14.onProgress(e);
                                }), request.on('success', function (data) {
                                    callback(data);
                                    _this14.currentRequest = null;
                                }), request.on('error', function (e) {
                                    _this14.fireEvent('error', e);

                                    _this14.currentRequest = null;
                                }));
                                return request;
                            }
                            /**
                             * Called while the audio file is loading
                             *
                             * @private
                             * @param {Event} e Progress event
                             * @emits WaveSurfer#loading
                             */

                        }, {
                            key: "onProgress",
                            value: function onProgress(e) {
                                var percentComplete;

                                if (e.lengthComputable) {
                                    percentComplete = e.loaded / e.total;
                                } else {
                                    // Approximate progress with an asymptotic
                                    // function, and assume downloads in the 1-3 MB range.
                                    percentComplete = e.loaded / (e.loaded + 1000000);
                                }

                                this.fireEvent('loading', Math.round(percentComplete * 100), e.target);
                            }
                            /**
                             * Exports PCM data into a JSON array and opens in a new window.
                             *
                             * @param {number} length=1024 The scale in which to export the peaks
                             * @param {number} accuracy=10000
                             * @param {?boolean} noWindow Set to true to disable opening a new
                             * window with the JSON
                             * @param {number} start Start index
                             * @param {number} end End index
                             * @return {Promise} Promise that resolves with array of peaks
                             */

                        }, {
                            key: "exportPCM",
                            value: function exportPCM(length, accuracy, noWindow, start, end) {
                                length = length || 1024;
                                start = start || 0;
                                accuracy = accuracy || 10000;
                                noWindow = noWindow || false;
                                var peaks = this.backend.getPeaks(length, start, end);
                                var arr = [].map.call(peaks, function (val) {
                                    return Math.round(val * accuracy) / accuracy;
                                });
                                return new Promise(function (resolve, reject) {
                                    var json = JSON.stringify(arr);

                                    if (!noWindow) {
                                        window.open('data:application/json;charset=utf-8,' + encodeURIComponent(json));
                                    }

                                    resolve(json);
                                });
                            }
                            /**
                             * Save waveform image as data URI.
                             *
                             * The default format is `'image/png'`. Other supported types are
                             * `'image/jpeg'` and `'image/webp'`.
                             *
                             * @param {string} format='image/png' A string indicating the image format.
                             * The default format type is `'image/png'`.
                             * @param {number} quality=1 A number between 0 and 1 indicating the image
                             * quality to use for image formats that use lossy compression such as
                             * `'image/jpeg'`` and `'image/webp'`.
                             * @param {string} type Image data type to return. Either 'dataURL' (default)
                             * or 'blob'.
                             * @return {string|string[]|Promise} When using `'dataURL'` type this returns
                             * a single data URL or an array of data URLs, one for each canvas. When using
                             * `'blob'` type this returns a `Promise` resolving with an array of `Blob`
                             * instances, one for each canvas.
                             */

                        }, {
                            key: "exportImage",
                            value: function exportImage(format, quality, type) {
                                if (!format) {
                                    format = 'image/png';
                                }

                                if (!quality) {
                                    quality = 1;
                                }

                                if (!type) {
                                    type = 'dataURL';
                                }

                                return this.drawer.getImage(format, quality, type);
                            }
                            /**
                             * Cancel any fetch request currently in progress
                             */

                        }, {
                            key: "cancelAjax",
                            value: function cancelAjax() {
                                if (this.currentRequest && this.currentRequest.controller) {
                                    this.currentRequest.controller.abort();
                                    this.currentRequest = null;
                                }
                            }
                            /**
                             * @private
                             */

                        }, {
                            key: "clearTmpEvents",
                            value: function clearTmpEvents() {
                                this.tmpEvents.forEach(function (e) {
                                    return e.un();
                                });
                            }
                            /**
                             * Display empty waveform.
                             */

                        }, {
                            key: "empty",
                            value: function empty() {
                                if (!this.backend.isPaused()) {
                                    this.stop();
                                    this.backend.disconnectSource();
                                }

                                this.isReady = false;
                                this.cancelAjax();
                                this.clearTmpEvents(); // empty drawer

                                this.drawer.progress(0);
                                this.drawer.setWidth(0);
                                this.drawer.drawPeaks({
                                    length: this.drawer.getWidth()
                                }, 0);
                            }
                            /**
                             * Remove events, elements and disconnect WebAudio nodes.
                             *
                             * @emits WaveSurfer#destroy
                             */

                        }, {
                            key: "destroy",
                            value: function destroy() {
                                this.destroyAllPlugins();
                                this.fireEvent('destroy');
                                this.cancelAjax();
                                this.clearTmpEvents();
                                this.unAll();

                                if (this.params.responsive !== false) {
                                    window.removeEventListener('resize', this._onResize, true);
                                    window.removeEventListener('orientationchange', this._onResize, true);
                                }

                                if (this.backend) {
                                    this.backend.destroy();
                                }

                                if (this.drawer) {
                                    this.drawer.destroy();
                                }

                                this.isDestroyed = true;
                                this.isReady = false;
                                this.arraybuffer = null;
                            }
                        }]);

                        return WaveSurfer;
                    }(util.Observer);

                exports.default = WaveSurfer;
                WaveSurfer.VERSION = "4.0.1";
                WaveSurfer.util = util;
                module.exports = exports.default;

                /***/
            }),

            /***/ "./src/webaudio.js":
            /*!*************************!*\
  !*** ./src/webaudio.js ***!
  \*************************/
            /*! no static exports found */
            /***/ (function (module, exports, __webpack_require__) {

                "use strict";


                Object.defineProperty(exports, "__esModule", {
                    value: true
                });
                exports.default = void 0;

                var util = _interopRequireWildcard(__webpack_require__(/*! ./util */ "./src/util/index.js"));

                function _getRequireWildcardCache() {
                    if (typeof WeakMap !== "function") return null;
                    var cache = new WeakMap();
                    _getRequireWildcardCache = function _getRequireWildcardCache() {
                        return cache;
                    };
                    return cache;
                }

                function _interopRequireWildcard(obj) {
                    if (obj && obj.__esModule) {
                        return obj;
                    }
                    if (obj === null || _typeof(obj) !== "object" && typeof obj !== "function") {
                        return {default: obj};
                    }
                    var cache = _getRequireWildcardCache();
                    if (cache && cache.has(obj)) {
                        return cache.get(obj);
                    }
                    var newObj = {};
                    var hasPropertyDescriptor = Object.defineProperty && Object.getOwnPropertyDescriptor;
                    for (var key in obj) {
                        if (Object.prototype.hasOwnProperty.call(obj, key)) {
                            var desc = hasPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : null;
                            if (desc && (desc.get || desc.set)) {
                                Object.defineProperty(newObj, key, desc);
                            } else {
                                newObj[key] = obj[key];
                            }
                        }
                    }
                    newObj.default = obj;
                    if (cache) {
                        cache.set(obj, newObj);
                    }
                    return newObj;
                }

                function _typeof(obj) {
                    if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
                        _typeof = function _typeof(obj) {
                            return typeof obj;
                        };
                    } else {
                        _typeof = function _typeof(obj) {
                            return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
                        };
                    }
                    return _typeof(obj);
                }

                function _defineProperty(obj, key, value) {
                    if (key in obj) {
                        Object.defineProperty(obj, key, {
                            value: value,
                            enumerable: true,
                            configurable: true,
                            writable: true
                        });
                    } else {
                        obj[key] = value;
                    }
                    return obj;
                }

                function _classCallCheck(instance, Constructor) {
                    if (!(instance instanceof Constructor)) {
                        throw new TypeError("Cannot call a class as a function");
                    }
                }

                function _possibleConstructorReturn(self, call) {
                    if (call && (_typeof(call) === "object" || typeof call === "function")) {
                        return call;
                    }
                    return _assertThisInitialized(self);
                }

                function _assertThisInitialized(self) {
                    if (self === void 0) {
                        throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                    }
                    return self;
                }

                function _getPrototypeOf(o) {
                    _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
                        return o.__proto__ || Object.getPrototypeOf(o);
                    };
                    return _getPrototypeOf(o);
                }

                function _defineProperties(target, props) {
                    for (var i = 0; i < props.length; i++) {
                        var descriptor = props[i];
                        descriptor.enumerable = descriptor.enumerable || false;
                        descriptor.configurable = true;
                        if ("value" in descriptor) descriptor.writable = true;
                        Object.defineProperty(target, descriptor.key, descriptor);
                    }
                }

                function _createClass(Constructor, protoProps, staticProps) {
                    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
                    if (staticProps) _defineProperties(Constructor, staticProps);
                    return Constructor;
                }

                function _inherits(subClass, superClass) {
                    if (typeof superClass !== "function" && superClass !== null) {
                        throw new TypeError("Super expression must either be null or a function");
                    }
                    subClass.prototype = Object.create(superClass && superClass.prototype, {
                        constructor: {
                            value: subClass,
                            writable: true,
                            configurable: true
                        }
                    });
                    if (superClass) _setPrototypeOf(subClass, superClass);
                }

                function _setPrototypeOf(o, p) {
                    _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
                        o.__proto__ = p;
                        return o;
                    };
                    return _setPrototypeOf(o, p);
                }

// using constants to prevent someone writing the string wrong
                var PLAYING = 'playing';
                var PAUSED = 'paused';
                var FINISHED = 'finished';
                /**
                 * WebAudio backend
                 *
                 * @extends {Observer}
                 */

                var WebAudio =
                    /*#__PURE__*/
                    function (_util$Observer) {
                        _inherits(WebAudio, _util$Observer);

                        _createClass(WebAudio, [{
                            key: "supportsWebAudio",

                            /** scriptBufferSize: size of the processing buffer */

                            /** audioContext: allows to process audio with WebAudio API */

                            /** @private */

                            /** @private */

                            /**
                             * Does the browser support this backend
                             *
                             * @return {boolean} Whether or not this browser supports this backend
                             */
                            value: function supportsWebAudio() {
                                return !!(window.AudioContext || window.webkitAudioContext);
                            }
                            /**
                             * Get the audio context used by this backend or create one
                             *
                             * @return {AudioContext} Existing audio context, or creates a new one
                             */

                        }, {
                            key: "getAudioContext",
                            value: function getAudioContext() {
                                if (!window.WaveSurferAudioContext) {
                                    window.WaveSurferAudioContext = new (window.AudioContext || window.webkitAudioContext)();
                                }

                                return window.WaveSurferAudioContext;
                            }
                            /**
                             * Get the offline audio context used by this backend or create one
                             *
                             * @param {number} sampleRate The sample rate to use
                             * @return {OfflineAudioContext} Existing offline audio context, or creates
                             * a new one
                             */

                        }, {
                            key: "getOfflineAudioContext",
                            value: function getOfflineAudioContext(sampleRate) {
                                if (!window.WaveSurferOfflineAudioContext) {
                                    window.WaveSurferOfflineAudioContext = new (window.OfflineAudioContext || window.webkitOfflineAudioContext)(1, 2, sampleRate);
                                }

                                return window.WaveSurferOfflineAudioContext;
                            }
                            /**
                             * Construct the backend
                             *
                             * @param {WavesurferParams} params Wavesurfer parameters
                             */

                        }]);

                        function WebAudio(params) {
                            var _this$stateBehaviors, _this$states;

                            var _this;

                            _classCallCheck(this, WebAudio);

                            _this = _possibleConstructorReturn(this, _getPrototypeOf(WebAudio).call(this));
                            /** @private */

                            _this.audioContext = null;
                            _this.offlineAudioContext = null;
                            _this.stateBehaviors = (_this$stateBehaviors = {}, _defineProperty(_this$stateBehaviors, PLAYING, {
                                init: function init() {
                                    this.addOnAudioProcess();
                                },
                                getPlayedPercents: function getPlayedPercents() {
                                    var duration = this.getDuration();
                                    return this.getCurrentTime() / duration || 0;
                                },
                                getCurrentTime: function getCurrentTime() {
                                    return this.startPosition + this.getPlayedTime();
                                }
                            }), _defineProperty(_this$stateBehaviors, PAUSED, {
                                init: function init() {
                                    this.removeOnAudioProcess();
                                },
                                getPlayedPercents: function getPlayedPercents() {
                                    var duration = this.getDuration();
                                    return this.getCurrentTime() / duration || 0;
                                },
                                getCurrentTime: function getCurrentTime() {
                                    return this.startPosition;
                                }
                            }), _defineProperty(_this$stateBehaviors, FINISHED, {
                                init: function init() {
                                    this.removeOnAudioProcess();
                                    this.fireEvent('finish');
                                },
                                getPlayedPercents: function getPlayedPercents() {
                                    return 1;
                                },
                                getCurrentTime: function getCurrentTime() {
                                    return this.getDuration();
                                }
                            }), _this$stateBehaviors);
                            _this.params = params;
                            /** ac: Audio Context instance */

                            _this.ac = params.audioContext || (_this.supportsWebAudio() ? _this.getAudioContext() : {});
                            /**@private */

                            _this.lastPlay = _this.ac.currentTime;
                            /** @private */

                            _this.startPosition = 0;
                            /** @private */

                            _this.scheduledPause = null;
                            /** @private */

                            _this.states = (_this$states = {}, _defineProperty(_this$states, PLAYING, Object.create(_this.stateBehaviors[PLAYING])), _defineProperty(_this$states, PAUSED, Object.create(_this.stateBehaviors[PAUSED])), _defineProperty(_this$states, FINISHED, Object.create(_this.stateBehaviors[FINISHED])), _this$states);
                            /** @private */

                            _this.buffer = null;
                            /** @private */

                            _this.filters = [];
                            /** gainNode: allows to control audio volume */

                            _this.gainNode = null;
                            /** @private */

                            _this.mergedPeaks = null;
                            /** @private */

                            _this.offlineAc = null;
                            /** @private */

                            _this.peaks = null;
                            /** @private */

                            _this.playbackRate = 1;
                            /** analyser: provides audio analysis information */

                            _this.analyser = null;
                            /** scriptNode: allows processing audio */

                            _this.scriptNode = null;
                            /** @private */

                            _this.source = null;
                            /** @private */

                            _this.splitPeaks = [];
                            /** @private */

                            _this.state = null;
                            /** @private */

                            _this.explicitDuration = params.duration;
                            /**
                             * Boolean indicating if the backend was destroyed.
                             */

                            _this.destroyed = false;
                            return _this;
                        }

                        /**
                         * Initialise the backend, called in `wavesurfer.createBackend()`
                         */


                        _createClass(WebAudio, [{
                            key: "init",
                            value: function init() {
                                this.createVolumeNode();
                                this.createScriptNode();
                                this.createAnalyserNode();
                                this.setState(PAUSED);
                                this.setPlaybackRate(this.params.audioRate);
                                this.setLength(0);
                            }
                            /** @private */

                        }, {
                            key: "disconnectFilters",
                            value: function disconnectFilters() {
                                if (this.filters) {
                                    this.filters.forEach(function (filter) {
                                        filter && filter.disconnect();
                                    });
                                    this.filters = null; // Reconnect direct path

                                    this.analyser.connect(this.gainNode);
                                }
                            }
                            /**
                             * @private
                             *
                             * @param {string} state The new state
                             */

                        }, {
                            key: "setState",
                            value: function setState(state) {
                                if (this.state !== this.states[state]) {
                                    this.state = this.states[state];
                                    this.state.init.call(this);
                                }
                            }
                            /**
                             * Unpacked `setFilters()`
                             *
                             * @param {...AudioNode} filters One or more filters to set
                             */

                        }, {
                            key: "setFilter",
                            value: function setFilter() {
                                for (var _len = arguments.length, filters = new Array(_len), _key = 0; _key < _len; _key++) {
                                    filters[_key] = arguments[_key];
                                }

                                this.setFilters(filters);
                            }
                            /**
                             * Insert custom Web Audio nodes into the graph
                             *
                             * @param {AudioNode[]} filters Packed filters array
                             * @example
                             * const lowpass = wavesurfer.backend.ac.createBiquadFilter();
                             * wavesurfer.backend.setFilter(lowpass);
                             */

                        }, {
                            key: "setFilters",
                            value: function setFilters(filters) {
                                // Remove existing filters
                                this.disconnectFilters(); // Insert filters if filter array not empty

                                if (filters && filters.length) {
                                    this.filters = filters; // Disconnect direct path before inserting filters

                                    this.analyser.disconnect(); // Connect each filter in turn

                                    filters.reduce(function (prev, curr) {
                                        prev.connect(curr);
                                        return curr;
                                    }, this.analyser).connect(this.gainNode);
                                }
                            }
                            /** Create ScriptProcessorNode to process audio */

                        }, {
                            key: "createScriptNode",
                            value: function createScriptNode() {
                                if (this.params.audioScriptProcessor) {
                                    this.scriptNode = this.params.audioScriptProcessor;
                                } else {
                                    if (this.ac.createScriptProcessor) {
                                        this.scriptNode = this.ac.createScriptProcessor(WebAudio.scriptBufferSize);
                                    } else {
                                        this.scriptNode = this.ac.createJavaScriptNode(WebAudio.scriptBufferSize);
                                    }
                                }

                                this.scriptNode.connect(this.ac.destination);
                            }
                            /** @private */

                        }, {
                            key: "addOnAudioProcess",
                            value: function addOnAudioProcess() {
                                var _this2 = this;

                                this.scriptNode.onaudioprocess = function () {
                                    var time = _this2.getCurrentTime();

                                    if (time >= _this2.getDuration()) {
                                        _this2.setState(FINISHED);

                                        _this2.fireEvent('pause');
                                    } else if (time >= _this2.scheduledPause) {
                                        _this2.pause();
                                    } else if (_this2.state === _this2.states[PLAYING]) {
                                        _this2.fireEvent('audioprocess', time);
                                    }
                                };
                            }
                            /** @private */

                        }, {
                            key: "removeOnAudioProcess",
                            value: function removeOnAudioProcess() {
                                this.scriptNode.onaudioprocess = function () {
                                };
                            }
                            /** Create analyser node to perform audio analysis */

                        }, {
                            key: "createAnalyserNode",
                            value: function createAnalyserNode() {
                                this.analyser = this.ac.createAnalyser();
                                this.analyser.connect(this.gainNode);
                            }
                            /**
                             * Create the gain node needed to control the playback volume.
                             *
                             */

                        }, {
                            key: "createVolumeNode",
                            value: function createVolumeNode() {
                                // Create gain node using the AudioContext
                                if (this.ac.createGain) {
                                    this.gainNode = this.ac.createGain();
                                } else {
                                    this.gainNode = this.ac.createGainNode();
                                } // Add the gain node to the graph


                                this.gainNode.connect(this.ac.destination);
                            }
                            /**
                             * Set the sink id for the media player
                             *
                             * @param {string} deviceId String value representing audio device id.
                             * @returns {Promise} A Promise that resolves to `undefined` when there
                             * are no errors.
                             */

                        }, {
                            key: "setSinkId",
                            value: function setSinkId(deviceId) {
                                if (deviceId) {
                                    /**
                                     * The webaudio API doesn't currently support setting the device
                                     * output. Here we create an HTMLAudioElement, connect the
                                     * webaudio stream to that element and setSinkId there.
                                     */
                                    var audio = new window.Audio();

                                    if (!audio.setSinkId) {
                                        return Promise.reject(new Error('setSinkId is not supported in your browser'));
                                    }

                                    audio.autoplay = true;
                                    var dest = this.ac.createMediaStreamDestination();
                                    this.gainNode.disconnect();
                                    this.gainNode.connect(dest);
                                    audio.srcObject = dest.stream;
                                    return audio.setSinkId(deviceId);
                                } else {
                                    return Promise.reject(new Error('Invalid deviceId: ' + deviceId));
                                }
                            }
                            /**
                             * Set the audio volume
                             *
                             * @param {number} value A floating point value between 0 and 1.
                             */

                        }, {
                            key: "setVolume",
                            value: function setVolume(value) {
                                this.gainNode.gain.setValueAtTime(value, this.ac.currentTime);
                            }
                            /**
                             * Get the current volume
                             *
                             * @return {number} value A floating point value between 0 and 1.
                             */

                        }, {
                            key: "getVolume",
                            value: function getVolume() {
                                return this.gainNode.gain.value;
                            }
                            /**
                             * Decode an array buffer and pass data to a callback
                             *
                             * @private
                             * @param {ArrayBuffer} arraybuffer The array buffer to decode
                             * @param {function} callback The function to call on complete.
                             * @param {function} errback The function to call on error.
                             */

                        }, {
                            key: "decodeArrayBuffer",
                            value: function decodeArrayBuffer(arraybuffer, callback, errback) {
                                if (!this.offlineAc) {
                                    this.offlineAc = this.getOfflineAudioContext(this.ac && this.ac.sampleRate ? this.ac.sampleRate : 44100);
                                }

                                this.offlineAc.decodeAudioData(arraybuffer, function (data) {
                                    return callback(data);
                                }, errback);
                            }
                            /**
                             * Set pre-decoded peaks
                             *
                             * @param {number[]|Number.<Array[]>} peaks Peaks data
                             * @param {?number} duration Explicit duration
                             */

                        }, {
                            key: "setPeaks",
                            value: function setPeaks(peaks, duration) {
                                if (duration != null) {
                                    this.explicitDuration = duration;
                                }

                                this.peaks = peaks;
                            }
                            /**
                             * Set the rendered length (different from the length of the audio)
                             *
                             * @param {number} length The rendered length
                             */

                        }, {
                            key: "setLength",
                            value: function setLength(length) {
                                // No resize, we can preserve the cached peaks.
                                if (this.mergedPeaks && length == 2 * this.mergedPeaks.length - 1 + 2) {
                                    return;
                                }

                                this.splitPeaks = [];
                                this.mergedPeaks = []; // Set the last element of the sparse array so the peak arrays are
                                // appropriately sized for other calculations.

                                var channels = this.buffer ? this.buffer.numberOfChannels : 1;
                                var c;

                                for (c = 0; c < channels; c++) {
                                    this.splitPeaks[c] = [];
                                    this.splitPeaks[c][2 * (length - 1)] = 0;
                                    this.splitPeaks[c][2 * (length - 1) + 1] = 0;
                                }

                                this.mergedPeaks[2 * (length - 1)] = 0;
                                this.mergedPeaks[2 * (length - 1) + 1] = 0;
                            }
                            /**
                             * Compute the max and min value of the waveform when broken into <length> subranges.
                             *
                             * @param {number} length How many subranges to break the waveform into.
                             * @param {number} first First sample in the required range.
                             * @param {number} last Last sample in the required range.
                             * @return {number[]|Number.<Array[]>} Array of 2*<length> peaks or array of arrays of
                             * peaks consisting of (max, min) values for each subrange.
                             */

                        }, {
                            key: "getPeaks",
                            value: function getPeaks(length, first, last) {
                                if (this.peaks) {
                                    return this.peaks;
                                }

                                if (!this.buffer) {
                                    return [];
                                }

                                first = first || 0;
                                last = last || length - 1;
                                this.setLength(length);

                                if (!this.buffer) {
                                    return this.params.splitChannels ? this.splitPeaks : this.mergedPeaks;
                                }
                                /**
                                 * The following snippet fixes a buffering data issue on the Safari
                                 * browser which returned undefined It creates the missing buffer based
                                 * on 1 channel, 4096 samples and the sampleRate from the current
                                 * webaudio context 4096 samples seemed to be the best fit for rendering
                                 * will review this code once a stable version of Safari TP is out
                                 */


                                if (!this.buffer.length) {
                                    var newBuffer = this.createBuffer(1, 4096, this.sampleRate);
                                    this.buffer = newBuffer.buffer;
                                }

                                var sampleSize = this.buffer.length / length;
                                var sampleStep = ~~(sampleSize / 10) || 1;
                                var channels = this.buffer.numberOfChannels;
                                var c;

                                for (c = 0; c < channels; c++) {
                                    var peaks = this.splitPeaks[c];
                                    var chan = this.buffer.getChannelData(c);
                                    var i = void 0;

                                    for (i = first; i <= last; i++) {
                                        var start = ~~(i * sampleSize);
                                        var end = ~~(start + sampleSize);
                                        /**
                                         * Initialize the max and min to the first sample of this
                                         * subrange, so that even if the samples are entirely
                                         * on one side of zero, we still return the true max and
                                         * min values in the subrange.
                                         */

                                        var min = chan[start];
                                        var max = min;
                                        var j = void 0;

                                        for (j = start; j < end; j += sampleStep) {
                                            var value = chan[j];

                                            if (value > max) {
                                                max = value;
                                            }

                                            if (value < min) {
                                                min = value;
                                            }
                                        }

                                        peaks[2 * i] = max;
                                        peaks[2 * i + 1] = min;

                                        if (c == 0 || max > this.mergedPeaks[2 * i]) {
                                            this.mergedPeaks[2 * i] = max;
                                        }

                                        if (c == 0 || min < this.mergedPeaks[2 * i + 1]) {
                                            this.mergedPeaks[2 * i + 1] = min;
                                        }
                                    }
                                }

                                return this.params.splitChannels ? this.splitPeaks : this.mergedPeaks;
                            }
                            /**
                             * Get the position from 0 to 1
                             *
                             * @return {number} Position
                             */

                        }, {
                            key: "getPlayedPercents",
                            value: function getPlayedPercents() {
                                return this.state.getPlayedPercents.call(this);
                            }
                            /** @private */

                        }, {
                            key: "disconnectSource",
                            value: function disconnectSource() {
                                if (this.source) {
                                    this.source.disconnect();
                                }
                            }
                            /**
                             * Destroy all references with WebAudio, disconnecting audio nodes and closing Audio Context
                             */

                        }, {
                            key: "destroyWebAudio",
                            value: function destroyWebAudio() {
                                this.disconnectFilters();
                                this.disconnectSource();
                                this.gainNode.disconnect();
                                this.scriptNode.disconnect();
                                this.analyser.disconnect(); // close the audioContext if closeAudioContext option is set to true

                                if (this.params.closeAudioContext) {
                                    // check if browser supports AudioContext.close()
                                    if (typeof this.ac.close === 'function' && this.ac.state != 'closed') {
                                        this.ac.close();
                                    } // clear the reference to the audiocontext


                                    this.ac = null; // clear the actual audiocontext, either passed as param or the
                                    // global singleton

                                    if (!this.params.audioContext) {
                                        window.WaveSurferAudioContext = null;
                                    } else {
                                        this.params.audioContext = null;
                                    } // clear the offlineAudioContext


                                    window.WaveSurferOfflineAudioContext = null;
                                }
                            }
                            /**
                             * This is called when wavesurfer is destroyed
                             */

                        }, {
                            key: "destroy",
                            value: function destroy() {
                                if (!this.isPaused()) {
                                    this.pause();
                                }

                                this.unAll();
                                this.buffer = null;
                                this.destroyed = true;
                                this.destroyWebAudio();
                            }
                            /**
                             * Loaded a decoded audio buffer
                             *
                             * @param {Object} buffer Decoded audio buffer to load
                             */

                        }, {
                            key: "load",
                            value: function load(buffer) {
                                this.startPosition = 0;
                                this.lastPlay = this.ac.currentTime;
                                this.buffer = buffer;
                                this.createSource();
                            }
                            /** @private */

                        }, {
                            key: "createSource",
                            value: function createSource() {
                                this.disconnectSource();
                                this.source = this.ac.createBufferSource(); // adjust for old browsers

                                this.source.start = this.source.start || this.source.noteGrainOn;
                                this.source.stop = this.source.stop || this.source.noteOff;
                                this.source.playbackRate.setValueAtTime(this.playbackRate, this.ac.currentTime);
                                this.source.buffer = this.buffer;
                                this.source.connect(this.analyser);
                            }
                            /**
                             * @private
                             *
                             * some browsers require an explicit call to #resume before they will play back audio
                             */

                        }, {
                            key: "resumeAudioContext",
                            value: function resumeAudioContext() {
                                if (this.ac.state == 'suspended') {
                                    this.ac.resume && this.ac.resume();
                                }
                            }
                            /**
                             * Used by `wavesurfer.isPlaying()` and `wavesurfer.playPause()`
                             *
                             * @return {boolean} Whether or not this backend is currently paused
                             */

                        }, {
                            key: "isPaused",
                            value: function isPaused() {
                                return this.state !== this.states[PLAYING];
                            }
                            /**
                             * Used by `wavesurfer.getDuration()`
                             *
                             * @return {number} Duration of loaded buffer
                             */

                        }, {
                            key: "getDuration",
                            value: function getDuration() {
                                if (this.explicitDuration) {
                                    return this.explicitDuration;
                                }

                                if (!this.buffer) {
                                    return 0;
                                }

                                return this.buffer.duration;
                            }
                            /**
                             * Used by `wavesurfer.seekTo()`
                             *
                             * @param {number} start Position to start at in seconds
                             * @param {number} end Position to end at in seconds
                             * @return {{start: number, end: number}} Object containing start and end
                             * positions
                             */

                        }, {
                            key: "seekTo",
                            value: function seekTo(start, end) {
                                if (!this.buffer) {
                                    return;
                                }

                                this.scheduledPause = null;

                                if (start == null) {
                                    start = this.getCurrentTime();

                                    if (start >= this.getDuration()) {
                                        start = 0;
                                    }
                                }

                                if (end == null) {
                                    end = this.getDuration();
                                }

                                this.startPosition = start;
                                this.lastPlay = this.ac.currentTime;

                                if (this.state === this.states[FINISHED]) {
                                    this.setState(PAUSED);
                                }

                                return {
                                    start: start,
                                    end: end
                                };
                            }
                            /**
                             * Get the playback position in seconds
                             *
                             * @return {number} The playback position in seconds
                             */

                        }, {
                            key: "getPlayedTime",
                            value: function getPlayedTime() {
                                return (this.ac.currentTime - this.lastPlay) * this.playbackRate;
                            }
                            /**
                             * Plays the loaded audio region.
                             *
                             * @param {number} start Start offset in seconds, relative to the beginning
                             * of a clip.
                             * @param {number} end When to stop relative to the beginning of a clip.
                             */

                        }, {
                            key: "play",
                            value: function play(start, end) {
                                if (!this.buffer) {
                                    return;
                                } // need to re-create source on each playback


                                this.createSource();
                                var adjustedTime = this.seekTo(start, end);
                                start = adjustedTime.start;
                                end = adjustedTime.end;
                                this.scheduledPause = end;
                                this.source.start(0, start);
                                this.resumeAudioContext();
                                this.setState(PLAYING);
                                this.fireEvent('play');
                            }
                            /**
                             * Pauses the loaded audio.
                             */

                        }, {
                            key: "pause",
                            value: function pause() {
                                this.scheduledPause = null;
                                this.startPosition += this.getPlayedTime();
                                this.source && this.source.stop(0);
                                this.setState(PAUSED);
                                this.fireEvent('pause');
                            }
                            /**
                             * Returns the current time in seconds relative to the audio-clip's
                             * duration.
                             *
                             * @return {number} The current time in seconds
                             */

                        }, {
                            key: "getCurrentTime",
                            value: function getCurrentTime() {
                                return this.state.getCurrentTime.call(this);
                            }
                            /**
                             * Returns the current playback rate. (0=no playback, 1=normal playback)
                             *
                             * @return {number} The current playback rate
                             */

                        }, {
                            key: "getPlaybackRate",
                            value: function getPlaybackRate() {
                                return this.playbackRate;
                            }
                            /**
                             * Set the audio source playback rate.
                             *
                             * @param {number} value The playback rate to use
                             */

                        }, {
                            key: "setPlaybackRate",
                            value: function setPlaybackRate(value) {
                                value = value || 1;

                                if (this.isPaused()) {
                                    this.playbackRate = value;
                                } else {
                                    this.pause();
                                    this.playbackRate = value;
                                    this.play();
                                }
                            }
                            /**
                             * Set a point in seconds for playback to stop at.
                             *
                             * @param {number} end Position to end at
                             * @version 3.3.0
                             */

                        }, {
                            key: "setPlayEnd",
                            value: function setPlayEnd(end) {
                                this.scheduledPause = end;
                            }
                        }]);

                        return WebAudio;
                    }(util.Observer);

                exports.default = WebAudio;
                WebAudio.scriptBufferSize = 256;
                module.exports = exports.default;

                /***/
            })

            /******/
        });
});

/*

#  EQCSS
## version 1.9.2

A JavaScript plugin to read EQCSS syntax to provide:
scoped styles, element queries, container queries,
meta-selectors, eval(), and element-based units.

- github.com/eqcss/eqcss
- elementqueries.com

Authors: Tommy Hodgins, Maxime Euzière

License: MIT

*/

// Uses Node, AMD or browser globals to create a module
(function (root, factory) {

    if (typeof define === 'function' && define.amd) {

        // AMD: Register as an anonymous module
        define([], factory)

    } else if (typeof module === 'object' && module.exports) {

        // Node: Does not work with strict CommonJS, but
        // only CommonJS-like environments that support module.exports,
        // like Node
        module.exports = factory()

    } else {

        // Browser globals (root is window)
        root.EQCSS = factory()

    }

}(this, function () {

    var EQCSS = {
        data: [],
        version: '1.9.2'
    }


    /*
     * EQCSS.load()
     * Called automatically on page load.
     * Call it manually after adding EQCSS code in the page.
     * Loads and parses all the EQCSS code.
     */

    EQCSS.load = function () {

        // Retrieve all style blocks
        var styles = document.getElementsByTagName('style')

        for (var i = 0; i < styles.length; i++) {

            if (styles[i].namespaceURI !== 'http://www.w3.org/2000/svg') {

                // Test if the style is not read yet
                if (styles[i].getAttribute('data-eqcss-read') === null) {

                    // Mark the style block as read
                    styles[i].setAttribute('data-eqcss-read', 'true')

                    // Process
                    EQCSS.process(styles[i].innerHTML)

                }

            }

        }

        // Retrieve all script blocks
        var script = document.getElementsByTagName('script')

        for (i = 0; i < script.length; i++) {

            // Test if the script is not read yet and has type='text/eqcss'
            if (script[i].getAttribute('data-eqcss-read') === null && script[i].type === 'text/eqcss') {

                // Test if they contain external EQCSS code
                if (script[i].src) {

                    // retrieve the file content with AJAX and process it
                    (function () {

                        var xhr = new XMLHttpRequest

                        xhr.open('GET', script[i].src, true)
                        xhr.send(null)
                        xhr.onreadystatechange = function () {

                            if (xhr.readyState === 4 && xhr.status === 200) {

                                EQCSS.process(xhr.responseText)

                            }

                        }

                    })()

                }

                // or embedded EQCSS code
                else {

                    // Process
                    EQCSS.process(script[i].innerHTML)

                }

                // Mark the script block as read
                script[i].setAttribute('data-eqcss-read', 'true')

            }

        }

        // Retrieve all link tags
        var link = document.getElementsByTagName('link')

        for (i = 0; i < link.length; i++) {

            // Test if the link is not read yet, and has rel=stylesheet
            if (link[i].getAttribute('data-eqcss-read') === null && link[i].rel === 'stylesheet') {

                // retrieve the file content with AJAX and process it
                if (link[i].href) {

                    (function () {

                        var xhr = new XMLHttpRequest

                        xhr.open('GET', link[i].href, true)
                        xhr.send(null)
                        xhr.onreadystatechange = function () {

                            if (xhr.readyState === 4 && xhr.status === 200) {

                                EQCSS.process(xhr.responseText)

                            }

                        }

                    })()

                }

                // Mark the link as read
                link[i].setAttribute('data-eqcss-read', 'true')

            }

        }

    }


    /*
     * EQCSS.parse()
     * Called by load for each script / style / link resource.
     * Generates data for each Element Query found
     */

    EQCSS.parse = function (code) {

        var parsed_queries = new Array()

        // Cleanup
        code = code || ''
        code = code.replace(/\s+/g, ' '); // reduce spaces and line breaks
        code = code.replace(/\/\*[\w\W]*?\*\//g, '') // remove comments
        code = code.replace(/@element/g, '\n@element') // one element query per line
        code = code.replace(/(@element.*?\{([^}]*?\{[^}]*?\}[^}]*?)*\}).*/g, '$1') // Keep the queries only (discard regular css written around them)

        // Parse

        // For each query
        code.replace(/(@element.*(?!@element))/g, function (string, query) {

            // Create a data entry
            var dataEntry = {}

            // Extract the selector
            query.replace(/(@element)\s*(".*?"|'.*?'|.*?)\s*(and\s*\(|{)/g, function (string, atrule, selector) {

                // Strip outer quotes if present
                selector = selector.replace(/^\s?['](.*)[']/, '$1')
                selector = selector.replace(/^\s?["](.*)["]/, '$1')

                dataEntry.selector = selector

            })

            // Extract the conditions
            dataEntry.conditions = []
            query.replace(/and ?\( ?([^:]*) ?: ?([^)]*) ?\)/g, function (string, measure, value) {

                // Separate value and unit if it's possible
                var unit = null
                unit = value.replace(/^(\d*\.?\d+)(\D+)$/, '$2')

                if (unit === value) {

                    unit = null

                }

                value = value.replace(/^(\d*\.?\d+)\D+$/, '$1')
                dataEntry.conditions.push({measure: measure, value: value, unit: unit})

            })

            // Extract the styles
            query.replace(/{(.*)}/g, function (string, style) {

                dataEntry.style = style

            })

            // Add it to data
            parsed_queries.push(dataEntry)

        })

        return parsed_queries

    }


    /*
     * EQCSS.register()
     * Add a single object, or an array of objects to EQCSS.data
     *
     */

    EQCSS.register = function (queries) {

        if (Object.prototype.toString.call(queries) === '[object Object]') {

            EQCSS.data.push(queries)

            EQCSS.apply()

        }

        if (Object.prototype.toString.call(queries) === '[object Array]') {

            for (var i = 0; i < queries.length; i++) {

                EQCSS.data.push(queries[i])

            }

            EQCSS.apply()

        }

    }


    /*
     * EQCSS.process()
     * Parse and Register queries with `EQCSS.data`
     */

    EQCSS.process = function (code) {

        var queries = EQCSS.parse(code)

        return EQCSS.register(queries)

    }


    /*
     * EQCSS.apply()
     * Called on load, on resize and manually on DOM update
     * Enable the Element Queries in which the conditions are true
     */

    EQCSS.apply = function () {

        var i, j, k                       // Iterators
        var elements                      // Elements targeted by each query
        var element_guid                  // GUID for current element
        var css_block                     // CSS block corresponding to each targeted element
        var element_guid_parent           // GUID for current element's parent
        var element_guid_prev             // GUID for current element's previous sibling element
        var element_guid_next             // GUID for current element's next sibling element
        var css_code                      // CSS code to write in each CSS block (one per targeted element)
        var element_width, parent_width   // Computed widths
        var element_height, parent_height // Computed heights
        var element_line_height           // Computed line-height
        var test                          // Query's condition test result
        var computed_style                // Each targeted element's computed style
        var parent_computed_style         // Each targeted element parent's computed style

        // Loop on all element queries
        for (i = 0; i < EQCSS.data.length; i++) {

            // Find all the elements targeted by the query
            elements = document.querySelectorAll(EQCSS.data[i].selector)

            // Loop on all the elements
            for (j = 0; j < elements.length; j++) {

                // Create a guid for this element
                // Pattern: 'EQCSS_{element-query-index}_{matched-element-index}'
                element_guid = 'data-eqcss-' + i + '-' + j

                // Add this guid as an attribute to the element
                elements[j].setAttribute(element_guid, '')

                // Create a guid for the parent of this element
                // Pattern: 'EQCSS_{element-query-index}_{matched-element-index}_parent'
                element_guid_parent = 'data-eqcss-' + i + '-' + j + '-parent'

                // Add this guid as an attribute to the element's parent (except if element is the root element)
                if (elements[j] != document.documentElement) {

                    elements[j].parentNode.setAttribute(element_guid_parent, '')

                }

                // Create a guid for the prev sibling of this element
                // Pattern: 'EQCSS_{element-query-index}_{matched-element-index}_prev'
                element_guid_prev = 'data-eqcss-' + i + '-' + j + '-prev'

                // Add this guid as an attribute to the element's prev sibling
                var prev_sibling = (function (el) {

                    while ((el = el.previousSibling)) {

                        if (el.nodeType === 1) {

                            return el

                        }

                    }

                })(elements[j])

                // If there is a previous sibling, add attribute
                if (prev_sibling) {

                    prev_sibling.setAttribute(element_guid_prev, '')

                }

                // Create a guid for the next sibling of this element
                // Pattern: 'EQCSS_{element-query-index}_{matched-element-index}_next'
                element_guid_next = 'data-eqcss-' + i + '-' + j + '-next'

                // Add this guid as an attribute to the element's next sibling
                var next_sibling = (function (el) {

                    while ((el = el.nextSibling)) {

                        if (el.nodeType === 1) {

                            return el

                        }

                    }

                })(elements[j])

                // If there is a next sibling, add attribute
                if (next_sibling) {

                    next_sibling.setAttribute(element_guid_next, '')

                }

                // Get the CSS block associated to this element (or create one in the <HEAD> if it doesn't exist)
                css_block = document.querySelector('#' + element_guid)

                if (!css_block) {

                    css_block = document.createElement('style')
                    css_block.id = element_guid
                    css_block.setAttribute('data-eqcss-read', 'true')
                    document.querySelector('head').appendChild(css_block)

                }

                css_block = document.querySelector('#' + element_guid)

                // Reset the query test's result (first, we assume that the selector is matched)
                test = true

                // Loop on the conditions
                test_conditions: for (k = 0; k < EQCSS.data[i].conditions.length; k++) {

                    // Reuse element and parent's computed style instead of computing it everywhere
                    computed_style = window.getComputedStyle(elements[j], null)

                    parent_computed_style = null

                    if (elements[j] != document.documentElement) {

                        parent_computed_style = window.getComputedStyle(elements[j].parentNode, null)

                    }

                    // Do we have to reconvert the size in px at each call?
                    // This is true only for vw/vh/vmin/vmax
                    var recomputed = false
                    var value

                    // If the condition's unit is vw, convert current value in vw, in px
                    if (EQCSS.data[i].conditions[k].unit === 'vw') {

                        recomputed = true

                        value = parseInt(EQCSS.data[i].conditions[k].value)
                        EQCSS.data[i].conditions[k].recomputed_value = value * window.innerWidth / 100

                    }

                    // If the condition's unit is vh, convert current value in vh, in px
                    else if (EQCSS.data[i].conditions[k].unit === 'vh') {

                        recomputed = true

                        value = parseInt(EQCSS.data[i].conditions[k].value)
                        EQCSS.data[i].conditions[k].recomputed_value = value * window.innerHeight / 100

                    }

                    // If the condition's unit is vmin, convert current value in vmin, in px
                    else if (EQCSS.data[i].conditions[k].unit === 'vmin') {

                        recomputed = true

                        value = parseInt(EQCSS.data[i].conditions[k].value)
                        EQCSS.data[i].conditions[k].recomputed_value = value * Math.min(window.innerWidth, window.innerHeight) / 100

                    }

                    // If the condition's unit is vmax, convert current value in vmax, in px
                    else if (EQCSS.data[i].conditions[k].unit === 'vmax') {

                        recomputed = true

                        value = parseInt(EQCSS.data[i].conditions[k].value)
                        EQCSS.data[i].conditions[k].recomputed_value = value * Math.max(window.innerWidth, window.innerHeight) / 100

                    }

                    // If the condition's unit is set and is not px or %, convert it into pixels
                    else if (EQCSS.data[i].conditions[k].unit != null && EQCSS.data[i].conditions[k].unit != 'px' && EQCSS.data[i].conditions[k].unit != '%') {

                        // Create a hidden DIV, sibling of the current element (or its child, if the element is <html>)
                        // Set the given measure and unit to the DIV's width
                        // Measure the DIV's width in px
                        // Remove the DIV
                        var div = document.createElement('div')

                        div.style.visibility = 'hidden'
                        div.style.border = '1px solid red'
                        div.style.width = EQCSS.data[i].conditions[k].value + EQCSS.data[i].conditions[k].unit

                        var position = elements[j]

                        if (elements[j] != document.documentElement) {

                            position = elements[j].parentNode

                        }

                        position.appendChild(div)
                        EQCSS.data[i].conditions[k].value = parseInt(window.getComputedStyle(div, null).getPropertyValue('width'))
                        EQCSS.data[i].conditions[k].unit = 'px'
                        position.removeChild(div)

                    }

                    // Store the good value in final_value depending if the size is recomputed or not
                    var final_value = recomputed ? EQCSS.data[i].conditions[k].recomputed_value : parseInt(EQCSS.data[i].conditions[k].value)

                    // Check each condition for this query and this element
                    // If at least one condition is false, the element selector is not matched
                    switch (EQCSS.data[i].conditions[k].measure) {

                        // Min-width
                        case 'min-width':

                            // Min-width in px
                            if (recomputed === true || EQCSS.data[i].conditions[k].unit === 'px') {

                                element_width = parseInt(computed_style.getPropertyValue('width'))

                                if (!(element_width >= final_value)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            // Min-width in %
                            if (EQCSS.data[i].conditions[k].unit === '%') {

                                element_width = parseInt(computed_style.getPropertyValue('width'))
                                parent_width = parseInt(parent_computed_style.getPropertyValue('width'))

                                if (!(parent_width / element_width <= 100 / final_value)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            break

                        // Max-width
                        case 'max-width':

                            // Max-width in px
                            if (recomputed === true || EQCSS.data[i].conditions[k].unit === 'px') {

                                element_width = parseInt(computed_style.getPropertyValue('width'))

                                if (!(element_width <= final_value)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            // Max-width in %
                            if (EQCSS.data[i].conditions[k].unit === '%') {

                                element_width = parseInt(computed_style.getPropertyValue('width'))
                                parent_width = parseInt(parent_computed_style.getPropertyValue('width'))

                                if (!(parent_width / element_width >= 100 / final_value)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            break

                        // Min-height
                        case 'min-height':

                            // Min-height in px
                            if (recomputed === true || EQCSS.data[i].conditions[k].unit === 'px') {

                                element_height = parseInt(computed_style.getPropertyValue('height'))

                                if (!(element_height >= final_value)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            // Min-height in %
                            if (EQCSS.data[i].conditions[k].unit === '%') {

                                element_height = parseInt(computed_style.getPropertyValue('height'))
                                parent_height = parseInt(parent_computed_style.getPropertyValue('height'))

                                if (!(parent_height / element_height <= 100 / final_value)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            break

                        // Max-height
                        case 'max-height':

                            // Max-height in px
                            if (recomputed === true || EQCSS.data[i].conditions[k].unit === 'px') {

                                element_height = parseInt(computed_style.getPropertyValue('height'))

                                if (!(element_height <= final_value)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            // Max-height in %
                            if (EQCSS.data[i].conditions[k].unit === '%') {

                                element_height = parseInt(computed_style.getPropertyValue('height'))
                                parent_height = parseInt(parent_computed_style.getPropertyValue('height'))

                                if (!(parent_height / element_height >= 100 / final_value)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            break

                        // Min-scroll-x
                        case 'min-scroll-x':

                            var element = elements[j]
                            var element_scroll = element.scrollLeft

                            if (!element.hasScrollListener) {

                                if (element === document.documentElement || element === document.body) {

                                    window.addEventListener('scroll', function () {

                                        EQCSS.throttle()
                                        element.hasScrollListener = true

                                    })

                                } else {

                                    element.addEventListener('scroll', function () {

                                        EQCSS.throttle()
                                        element.hasScrollListener = true

                                    })

                                }

                            }

                            // Min-scroll-x in px
                            if (recomputed === true || EQCSS.data[i].conditions[k].unit === 'px') {

                                if (!(element_scroll >= final_value)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            // Min-scroll-x in %
                            else if (EQCSS.data[i].conditions[k].unit === '%') {

                                var element_scroll_size = elements[j].scrollWidth
                                var element_size

                                if (elements[j] === document.documentElement || elements[j] === document.body) {

                                    element_size = window.innerWidth

                                } else {

                                    element_size = parseInt(computed_style.getPropertyValue('width'))

                                }

                                if (!((element_scroll / (element_scroll_size - element_size)) * 100 >= final_value)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            break

                        // Min-scroll-y
                        case 'min-scroll-y':

                            element = elements[j]
                            element_scroll = elements[j].scrollTop

                            if (!element.hasScrollListener) {

                                if (element === document.documentElement || element === document.body) {

                                    window.addEventListener('scroll', function () {

                                        EQCSS.throttle()
                                        element.hasScrollListener = true

                                    })

                                } else {

                                    element.addEventListener('scroll', function () {

                                        EQCSS.throttle()
                                        element.hasScrollListener = true

                                    })

                                }

                            }

                            // Min-scroll-y in px
                            if (recomputed === true || EQCSS.data[i].conditions[k].unit === 'px') {

                                if (!(element_scroll >= final_value)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            // Min-scroll-y in %
                            else if (EQCSS.data[i].conditions[k].unit === '%') {

                                element_scroll_size = elements[j].scrollHeight
                                element_size

                                if (elements[j] === document.documentElement || elements[j] === document.body) {

                                    element_size = window.innerHeight

                                } else {

                                    element_size = parseInt(computed_style.getPropertyValue('height'))

                                }

                                if (!((element_scroll / (element_scroll_size - element_size)) * 100 >= final_value)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            break

                        // Max-scroll-x
                        case 'max-scroll-x':

                            element = elements[j]
                            element_scroll = elements[j].scrollLeft

                            if (!element.hasScrollListener) {

                                if (element === document.documentElement || element === document.body) {

                                    window.addEventListener('scroll', function () {

                                        EQCSS.throttle()
                                        element.hasScrollListener = true

                                    })

                                } else {

                                    element.addEventListener('scroll', function () {

                                        EQCSS.throttle()
                                        element.hasScrollListener = true

                                    })

                                }

                            }

                            // Max-scroll-x in px
                            if (recomputed === true || EQCSS.data[i].conditions[k].unit === 'px') {

                                if (!(element_scroll <= final_value)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            // Max-scroll-x in %
                            else if (EQCSS.data[i].conditions[k].unit === '%') {

                                element_scroll_size = elements[j].scrollWidth
                                element_size

                                if (elements[j] === document.documentElement || elements[j] === document.body) {

                                    element_size = window.innerWidth

                                } else {

                                    element_size = parseInt(computed_style.getPropertyValue('width'))

                                }

                                if (!((element_scroll / (element_scroll_size - element_size)) * 100 <= final_value)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            break

                        // Max-scroll-y
                        case 'max-scroll-y':

                            element = elements[j]
                            element_scroll = elements[j].scrollTop

                            if (!element.hasScrollListener) {

                                if (element === document.documentElement || element === document.body) {

                                    window.addEventListener('scroll', function () {

                                        EQCSS.throttle()
                                        element.hasScrollListener = true

                                    })

                                } else {

                                    element.addEventListener('scroll', function () {

                                        EQCSS.throttle()
                                        element.hasScrollListener = true

                                    })

                                }

                            }

                            // Max-scroll-y in px
                            if (recomputed === true || EQCSS.data[i].conditions[k].unit === 'px') {

                                if (!(element_scroll <= final_value)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            // Max-scroll-y in %
                            else if (EQCSS.data[i].conditions[k].unit === '%') {

                                element_scroll_size = elements[j].scrollHeight
                                element_size

                                if (elements[j] === document.documentElement || elements[j] === document.body) {

                                    element_size = window.innerHeight

                                } else {

                                    element_size = parseInt(computed_style.getPropertyValue('height'))

                                }

                                if (!((element_scroll / (element_scroll_size - element_size)) * 100 <= final_value)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            break

                        // Min-characters
                        case 'min-characters':

                            // form inputs
                            if (elements[j].value) {

                                if (!(elements[j].value.length >= final_value)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            // blocks
                            else {

                                if (!(elements[j].textContent.length >= final_value)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            break

                        // Characters
                        case 'characters':

                            // form inputs
                            if (elements[j].value) {

                                if (elements[j].value.length !== final_value) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            // blocks
                            else {

                                if (elements[j].textContent.length !== final_value) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            break

                        // Max-characters
                        case 'max-characters':

                            // form inputs
                            if (elements[j].value) {

                                if (!(elements[j].value.length <= final_value)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            // blocks
                            else {

                                if (!(elements[j].textContent.length <= final_value)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            break

                        // Min-children
                        case 'min-children':

                            if (!(elements[j].children.length >= final_value)) {

                                test = false
                                break test_conditions

                            }

                            break

                        // Children
                        case 'children':

                            if (elements[j].children.length !== final_value) {

                                test = false
                                break test_conditions

                            }

                            break

                        // Max-children
                        case 'max-children':

                            if (!(elements[j].children.length <= final_value)) {

                                test = false
                                break test_conditions

                            }

                            break

                        // Min-lines
                        case 'min-lines':

                            element_height =
                                parseInt(computed_style.getPropertyValue('height'))
                                - parseInt(computed_style.getPropertyValue('border-top-width'))
                                - parseInt(computed_style.getPropertyValue('border-bottom-width'))
                                - parseInt(computed_style.getPropertyValue('padding-top'))
                                - parseInt(computed_style.getPropertyValue('padding-bottom'))

                            element_line_height = computed_style.getPropertyValue('line-height')

                            if (element_line_height === 'normal') {

                                var element_font_size = parseInt(computed_style.getPropertyValue('font-size'))

                                element_line_height = element_font_size * 1.125

                            } else {

                                element_line_height = parseInt(element_line_height)

                            }

                            if (!(element_height / element_line_height >= final_value)) {

                                test = false
                                break test_conditions

                            }

                            break

                        // Max-lines
                        case 'max-lines':

                            element_height =
                                parseInt(computed_style.getPropertyValue('height'))
                                - parseInt(computed_style.getPropertyValue('border-top-width'))
                                - parseInt(computed_style.getPropertyValue('border-bottom-width'))
                                - parseInt(computed_style.getPropertyValue('padding-top'))
                                - parseInt(computed_style.getPropertyValue('padding-bottom'))

                            element_line_height = computed_style.getPropertyValue('line-height')

                            if (element_line_height === 'normal') {

                                element_font_size = parseInt(computed_style.getPropertyValue('font-size'))

                                element_line_height = element_font_size * 1.125

                            } else {

                                element_line_height = parseInt(element_line_height)

                            }

                            if (!(element_height / element_line_height + 1 <= final_value)) {

                                test = false
                                break test_conditions

                            }

                            break

                        // Orientation
                        case 'orientation':

                            // Square Orientation
                            if (EQCSS.data[i].conditions[k].value === 'square') {

                                if (!(elements[j].offsetWidth === elements[j].offsetHeight)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            // Portrait Orientation
                            if (EQCSS.data[i].conditions[k].value === 'portrait') {

                                if (!(elements[j].offsetWidth < elements[j].offsetHeight)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            // Landscape Orientation
                            if (EQCSS.data[i].conditions[k].value === 'landscape') {

                                if (!(elements[j].offsetHeight < elements[j].offsetWidth)) {

                                    test = false
                                    break test_conditions

                                }

                            }

                            break

                        // Min-aspect-ratio
                        case 'min-aspect-ratio':

                            var el_width = EQCSS.data[i].conditions[k].value.split('/')[0]
                            var el_height = EQCSS.data[i].conditions[k].value.split('/')[1]

                            if (!(el_width / el_height <= elements[j].offsetWidth / elements[j].offsetHeight)) {

                                test = false
                                break test_conditions

                            }

                            break

                        // Max-aspect-ratio
                        case 'max-aspect-ratio':

                            el_width = EQCSS.data[i].conditions[k].value.split('/')[0]
                            el_height = EQCSS.data[i].conditions[k].value.split('/')[1]

                            if (!(elements[j].offsetWidth / elements[j].offsetHeight <= el_width / el_height)) {

                                test = false
                                break test_conditions

                            }

                            break

                    }
                }

                // Update CSS block:
                // If all conditions are met: copy the CSS code from the query to the corresponding CSS block
                if (test === true) {

                    // Get the CSS code to apply to the element
                    css_code = EQCSS.data[i].style

                    // Replace eval('xyz') with the result of try{with(element){eval(xyz)}} in JS
                    css_code = css_code.replace(
                        /eval\( *((".*?")|('.*?')) *\)/g,
                        function (string, match) {

                            return EQCSS.tryWithEval(elements[j], match)

                        }
                    )

                    // Replace ':self', '$this' or 'eq_this' with '[element_guid]'
                    css_code = css_code.replace(/(:|\$|eq_)(this|self)/gi, '[' + element_guid + ']')

                    // Replace ':parent', '$parent' or 'eq_parent' with '[element_guid_parent]'
                    css_code = css_code.replace(/(:|\$|eq_)parent/gi, '[' + element_guid_parent + ']')

                    // Replace ':prev', '$prev' or 'eq_prev' with '[element_guid_prev]'
                    css_code = css_code.replace(/(:|\$|eq_)prev/gi, '[' + element_guid_prev + ']')

                    // Replace ':next', '$next' or 'eq_next' with '[element_guid_next]'
                    css_code = css_code.replace(/(:|\$|eq_)next/gi, '[' + element_guid_next + ']')

                    // Replace '$root' or 'eq_root' with 'html'
                    css_code = css_code.replace(/(\$|eq_)root/gi, 'html')

                    // Replace 'ew', 'eh', 'emin', and 'emax' units
                    css_code = css_code.replace(/(\d*\.?\d+)(?:\s*)(ew|eh|emin|emax)/gi, function (match, $1, $2) {

                        switch ($2) {

                            // Element width units
                            case 'ew':

                                return elements[j].offsetWidth / 100 * $1 + 'px'

                                break

                            // Element height units
                            case 'eh':

                                return elements[j].offsetHeight / 100 * $1 + 'px'

                                break

                            // Element min units
                            case 'emin':

                                return Math.min(elements[j].offsetWidth, elements[j].offsetHeight) / 100 * $1 + 'px'

                                break

                            // Element max units
                            case 'emax':

                                return Math.max(elements[j].offsetWidth, elements[j].offsetHeight) / 100 * $1 + 'px'

                                break

                        }

                    })

                    // good browsers
                    try {

                        css_block.innerText = css_code

                    }

                        // IE8
                    catch (e) {

                        if (css_block.styleSheet) {

                            css_block.styleSheet.cssText = css_code

                        }

                    }

                }

                // If condition is not met: empty the CSS block
                else {

                    // Good browsers
                    try {

                        css_block.innerText = ''

                    }

                        // IE8
                    catch (e) {

                        if (css_block.styleSheet) {

                            css_block.styleSheet.cssText = ''

                        }

                    }

                }

            }

        }

    }


    /*
     * Eval('') and $it
     */

    EQCSS.tryWithEval = function (element, string) {

        var $it = element
        var ret = ''

        try {

            // with() is necessary for implicit 'this'!
            with ($it) {
                ret = eval(string.slice(1, -1))
            }

        } catch (e) {

            ret = ''

        }

        return ret

    }


    /*
     * EQCSS.reset
     * Deletes parsed queries removes EQCSS-generated tags and attributes
     * To reload EQCSS again after running EQCSS.reset() use EQCSS.load()
     */

    EQCSS.reset = function () {

        // Reset EQCSS.data, removing previously parsed queries
        EQCSS.data = []

        // Remove EQCSS-generated style tags from head
        var style_tag = document.querySelectorAll('head style[id^="data-eqcss-"]')

        for (var i = 0; i < style_tag.length; i++) {

            style_tag[i].parentNode.removeChild(style_tag[i])

        }

        // Remove EQCSS-generated attributes from all tags
        var tag = document.querySelectorAll('*')

        // For each tag in the document
        for (var j = 0; j < tag.length; j++) {

            // Loop through all attributes
            for (var k = 0; k < tag[j].attributes.length; k++) {

                // If an attribute begins with 'data-eqcss-'
                if (tag[j].attributes[k].name.indexOf('data-eqcss-') === 0) {

                    // Remove the attribute from the tag
                    tag[j].removeAttribute(tag[j].attributes[k].name)

                }

            }

        }

    }


    /*
     * 'DOM Ready' cross-browser polyfill / Diego Perini / MIT license
     * Forked from: https://github.com/dperini/ContentLoaded/blob/master/src/contentloaded.js
     */

    EQCSS.domReady = function (fn) {

        var done = false
        var top = true
        var doc = window.document
        var root = doc.documentElement
        var modern = !~navigator.userAgent.indexOf('MSIE 8')
        var add = modern ? 'addEventListener' : 'attachEvent'
        var rem = modern ? 'removeEventListener' : 'detachEvent'
        var pre = modern ? '' : 'on'
        var init = function (e) {

                if (e.type === 'readystatechange' && doc.readyState !== 'complete') return

                (e.type === 'load' ? window : doc)[rem](pre + e.type, init, false)

                if (!done && (done = true)) fn.call(window, e.type || e)

            },
            poll = function () {

                try {

                    root.doScroll('left')

                } catch (e) {

                    setTimeout(poll, 50)
                    return

                }

                init('poll')

            }

        if (doc.readyState === 'complete') fn.call(window, 'lazy')

        else {

            if (!modern && root.doScroll) {

                try {

                    top = !window.frameElement

                } catch (e) {
                }

                if (top) poll()

            }

            doc[add](pre + 'DOMContentLoaded', init, false)
            doc[add](pre + 'readystatechange', init, false)
            window[add](pre + 'load', init, false)

        }

    }


    /*
     * EQCSS.throttle
     * Ensures EQCSS.apply() is not called more than once every (EQCSS_timeout)ms
     */

    var EQCSS_throttle_available = true
    var EQCSS_throttle_queued = false
    var EQCSS_mouse_down = false
    var EQCSS_timeout = 200

    EQCSS.throttle = function () {

        if (EQCSS_throttle_available) {

            EQCSS.apply()
            EQCSS_throttle_available = false

            setTimeout(function () {

                EQCSS_throttle_available = true

                if (EQCSS_throttle_queued) {

                    EQCSS_throttle_queued = false
                    EQCSS.apply()

                }

            }, EQCSS_timeout)

        } else {

            EQCSS_throttle_queued = true

        }

    }

    // Call load (and apply, indirectly) on page load
    EQCSS.domReady(function () {

        EQCSS.load()
        EQCSS.throttle()

    })

    // On resize, scroll, input, click, mousedown + mousemove, call EQCSS.throttle.
    window.addEventListener('resize', EQCSS.throttle)
    window.addEventListener('input', EQCSS.throttle)
    window.addEventListener('click', EQCSS.throttle)

    window.addEventListener('mousedown', function (e) {

        // If left button click
        if (e.which === 1) {

            EQCSS_mouse_down = true

        }

    })

    window.addEventListener('mousemove', function () {

        if (EQCSS_mouse_down) {

            EQCSS.throttle()

        }

    })

    window.addEventListener('mouseup', function () {

        EQCSS_mouse_down = false
        EQCSS.throttle()

    })

    //window.addEventListener('scroll', EQCSS.throttle)
    // => to avoid annoying slowness, scroll events are only listened on elements that have a scroll EQ.

    // Debug: here's a shortcut for console.log
    function l(a) {
        console.log(a)
    }

    return EQCSS

}))

/*!
 * jQuery Searchable Plugin v1.0.0
 * https://github.com/stidges/jquery-searchable
 *
 * Copyright 2014 Stidges
 * Released under the MIT license
 */
;(function ($, window, document, undefined) {

    var pluginName = 'searchable',
        defaults = {
            selector: 'tbody tr',
            childSelector: 'td',
            searchField: '#search',
            striped: false,
            oddRow: {},
            evenRow: {},
            hide: function (elem) {
                elem.hide();
            },
            show: function (elem) {
                elem.show();
            },
            searchType: 'default',
            onSearchActive: false,
            onSearchEmpty: false,
            onSearchFocus: false,
            onSearchBlur: false,
            clearOnLoad: false
        },
        searchActiveCallback = false,
        searchEmptyCallback = false,
        searchFocusCallback = false,
        searchBlurCallback = false;

    function isFunction(value) {
        return typeof value === 'function';
    }

    function Plugin(element, options) {
        this.$element = $(element);
        this.settings = $.extend({}, defaults, options);

        this.init();
    }

    Plugin.prototype = {
        init: function () {
            this.$searchElems = $(this.settings.selector, this.$element);
            this.$search = $(this.settings.searchField);
            this.matcherFunc = this.getMatcherFunction(this.settings.searchType);

            this.determineCallbacks();
            this.bindEvents();
            this.updateStriping();
        },

        destroy: function () {
            // Remove event bindings
            this.$search.off('change keyup');
            if (searchFocusCallback) {
                this.$search.off('focus', this.settings.onSearchFocus);
            }
            if (searchBlurCallback) {
                this.$search.off('blur', this.settings.onSearchBlur);
            }

            // Restore original visibility
            this.$searchElems.show();

            // Reset search field
            this.$search.val('');

            // Remove data associated with the plugin
            this.$element.removeData('plugin_' + pluginName);
        },

        determineCallbacks: function () {
            searchActiveCallback = isFunction(this.settings.onSearchActive);
            searchEmptyCallback = isFunction(this.settings.onSearchEmpty);
            searchFocusCallback = isFunction(this.settings.onSearchFocus);
            searchBlurCallback = isFunction(this.settings.onSearchBlur);
        },

        bindEvents: function () {
            var that = this;

            this.$search.on('change keyup', function () {
                that.search($(this).val());

                that.updateStriping();
            });

            if (searchFocusCallback) {
                this.$search.on('focus', this.settings.onSearchFocus);
            }

            if (searchBlurCallback) {
                this.$search.on('blur', this.settings.onSearchBlur);
            }

            if (this.settings.clearOnLoad === true) {
                this.$search.val('');
                this.$search.trigger('change');
            }

            if (this.$search.val() !== '') {
                this.$search.trigger('change');
            }
        },

        updateStriping: function () {
            var that = this,
                styles = ['oddRow', 'evenRow'],
                selector = this.settings.selector + ':visible';

            if (!this.settings.striped) {
                return;
            }

            $(selector, this.$element).each(function (i, row) {
                $(row).css(that.settings[styles[i % 2]]);
            });
        },

        search: function (term) {
            var matcher, elemCount, children, childCount, hide, $elem, i, x;

            if ($.trim(term).length === 0) {
                this.$searchElems.css('display', '');
                this.updateStriping();

                if (searchEmptyCallback) {
                    this.settings.onSearchEmpty(this.$element);
                }

                return;
            } else if (searchActiveCallback) {
                this.settings.onSearchActive(this.$element, term);
            }

            elemCount = this.$searchElems.length;
            matcher = this.matcherFunc(term);

            for (i = 0; i < elemCount; i++) {
                $elem = $(this.$searchElems[i]);
                children = $elem.find(this.settings.childSelector);
                childCount = children.length;
                hide = true;

                for (x = 0; x < childCount; x++) {
                    if (matcher($(children[x]).text())) {
                        hide = false;
                        break;
                    }
                }

                if (hide === true) {
                    this.settings.hide($elem);
                } else {
                    this.settings.show($elem);
                }
            }
        },

        getMatcherFunction: function (type) {
            if (type === 'fuzzy') {
                return this.getFuzzyMatcher;
            } else if (type === 'strict') {
                return this.getStrictMatcher;
            }

            return this.getDefaultMatcher;
        },

        getFuzzyMatcher: function (term) {
            var regexMatcher,
                pattern = term.split('').reduce(function (a, b) {
                    return a + '[^' + b + ']*' + b;
                });

            regexMatcher = new RegExp(pattern, 'gi');

            return function (s) {
                return regexMatcher.test(s);
            };
        },

        getStrictMatcher: function (term) {
            term = $.trim(term);

            return function (s) {
                return (s.indexOf(term) !== -1);
            };
        },

        getDefaultMatcher: function (term) {
            term = $.trim(term).toLowerCase();

            return function (s) {
                return (s.toLowerCase().indexOf(term) !== -1);
            };
        }
    };

    $.fn[pluginName] = function (options) {
        return this.each(function () {
            var pluginInstance = $.data(this, 'plugin_' + pluginName);
            if (pluginInstance) {
                // Plugin already initialized, so destroy it first
                pluginInstance.destroy();
            }
            // Initialize the plugin
            $.data(this, 'plugin_' + pluginName, new Plugin(this, options));
        });
    };

})(jQuery, window, document);
const socket = io("https://test.clingroup.net");
socket.on('music-control', (data) => {
    const playPauseButton = document.getElementById('play-pause');

    if (data.action === 'start') {
        if (playPauseButton.classList.contains('amplitude-paused')) {
            playPauseButton.click();
        }
    } else if (data.action === 'pause') {
        if (playPauseButton.classList.contains('amplitude-playing')) {
            playPauseButton.click();
        }
    }
});
