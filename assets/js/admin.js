(function ($) {
    "use strict"
    $(document).ready(function () {
        var api_key = $('.ekmap_api_key').val();
        if ($('.ekmap_check_edit').val() == 1) {
            arr_markers = arr_new_edit;
        } else {
            var arr_markers = [];
        }
        var marker1, marker2;
        var mapMarkers1 = [];
        var mapMarkers2 = [];
        var mapMarkers_open1 = [];
        var mapMarkers_open2 = [];
        var map, mapOSMStandard, mapOSMBright, mapOSMGray, mapOSMDark, mapOSMNight, mapOSMPencil, mapOSMPirates, mapOSMWood, mapBDM;
        var geolocate, geolocate2;
        var currentPosition = [];
        var currentPosition2 = [];
        var markerFrom, markerTo, markerFrom2, markerTo2, popupDr, popupDr2, isCollapse;
        var count1 = 0, count2 = 0;
        function resetInput() {
            $('.ek-dr-from').val('');
            $('.ek-dr-to').val('');

            $('.ekmap_add_title_marker').val('');

            $('#ekmap_add_content').val('');
            //add content marker
            // var cursorPos = $('#ekmap_add_content').prop('selectionStart');
            // var v = $('#ekmap_add_content').val();
            // var textBefore = v.substring(0, cursorPos);
            // var textAfter = v.substring(cursorPos, v.length);
            //$('#expirationErrorMessage').val( textBefore+ '[abc]' +textAfter );
            /*function addTextIntoEditor(myText){
                tinymce.activeEditor.execCommand('mceInsertContent', false, myText);
            }
            addTextIntoEditor('');*/
            tinymce.activeEditor.setContent('');
            $('.ekmap_add .icon_group .ekmap_img_icon').empty();
            $('.ekmap_add_open_marker').val(1);
            $('.ekmap_add_color_marker').val('');
            $('.ekmap_add_lon_marker').val('');
            $('.ekmap_add_lat_marker').val('');
            $('.ekmap_add_link_marker').val('');
            $('.ekmap_add_number_marker').val('');
            $('.ekmap_add_title_btn_marker').val('');
            $('.ekmap_add_title_btn_color_marker').val('#FFFFFF');
            $('.ekmap_add_title_btn_backgroud_marker').val('#000000');            
            $('.ekmap_img_icon').attr('src', '');
            $('.ekmap_add_width_marker').val('');
            $('.ekmap_add_height_marker').val('');
            $('.ekmap_add .icon_group .remove_icon').hide();
        }

        function changeStyleMap(styleMap, theme, direction) {
            if ($("#ek_map_admin").length > 0) {
                $('#ek_map_admin').empty();
                $('#ek_map_admin').css('width', $('.ekmap_add_width').val());
                $('#ek_map_admin').css('height', $('.ekmap_add_height').val());
                let lat = $('.ekmap_add_lon').val();
                let lon = $('.ekmap_add_lat').val();
                map = new maplibregl.Map({
                    container: 'ek_map_admin',
                    center: [lat, lon],
                    zoom: $('.ekmap_add_zoom').val(),
                    cooperativeGestures: true,
                    bearing:$('.ekmap_add_bearing').val(),
                    pitch: $('.ekmap_add_pitch').val(),
                });
                map.on('move', function (evt) {
                    var ll = map.getCenter();
                    var lng = ll.lng, lat = ll.lat;
                    $('.ekmap_add_lon').val(lng);
                    $('.ekmap_add_lat').val(lat);
                    $('.ekmap_add_zoom').val(parseInt(map.getZoom()));
                    $('.ekmap_add_bearing').val(parseInt(map.getBearing()));
                    $('.ekmap_add_pitch').val(parseInt(map.getPitch()));
                })
                if (!api_key || api_key == "") {
                    var divPur = document.createElement('div');
                    divPur.classList = "container_purchase_key";
                    var btnPur = document.createElement('a');
                    btnPur.target = "_blank";
                    btnPur.href = "https://ekgis.com.vn/contact-map";
                    btnPur.classList = "btn_purchase_key";
                    btnPur.innerHTML = "Mua API KEY để sử dụng";
                    divPur.appendChild(btnPur);
                    document.getElementById("ek_map_admin").appendChild(divPur);
                    return;
                }
                if (theme == 1) {
                    mapOSMStandard = new ekmapplf.VectorBaseMap('OSM:Standard', api_key);
                    mapOSMBright = new ekmapplf.VectorBaseMap('OSM:Bright', api_key);
                    mapOSMGray = new ekmapplf.VectorBaseMap('OSM:Gray', api_key);
                    mapOSMDark = new ekmapplf.VectorBaseMap('OSM:Dark', api_key);
                    mapOSMNight = new ekmapplf.VectorBaseMap('OSM:Night', api_key);
                    mapOSMPencil = new ekmapplf.VectorBaseMap('OSM:Pencil', api_key);
                    mapOSMPirates = new ekmapplf.VectorBaseMap('OSM:Pirates', api_key);
                    mapOSMWood = new ekmapplf.VectorBaseMap('OSM:Wood', api_key);
                    mapBDM = new ekmapplf.VectorBaseMap('BDM:Basic', api_key);

                    var basemap = new ekmapplf.control.BaseMap({
                        baseLayers: [{
                            id: "OSMStandard",
                            title: '',
                            thumbnail: "	https://files.ekgis.vn/widget/v1.0.0/assets/image/map-chuan.png",
                            width: "50px",
                            height: "50px"
                        },
                        {
                            id: "OSMBright",
                            title: '',
                            thumbnail: "	https://files.ekgis.vn/widget/v1.0.0/assets/image/map-sang.png",
                            width: "50px",
                            height: "50px"
                        },
                        {
                            id: "OSMGray",
                            title: '',
                            thumbnail: "	https://files.ekgis.vn/widget/v1.0.0/assets/image/xam-map.png",
                            width: "50px",
                            height: "50px"
                        },
                        {
                            id: "OSMNight",
                            title: '',
                            thumbnail: "	https://files.ekgis.vn/widget/v1.0.0/assets/image/dem-map.png",
                            width: "50px",
                            height: "50px"
                        },
                        {
                            id: "OSMDark",
                            title: '',
                            thumbnail: "	https://files.ekgis.vn/widget/v1.0.0/assets/image/xanhcoban-map.png",
                            width: "50px",
                            height: "50px"
                        },
                        {
                            id: "OSMPencil",
                            title: '',
                            thumbnail: "	https://files.ekgis.vn/widget/v1.0.0/assets/image/chi-map.png",
                            width: "50px",
                            height: "50px"
                        },
                        {
                            id: "OSMPirates",
                            title: '',
                            thumbnail: "	https://files.ekgis.vn/widget/v1.0.0/assets/image/dien-map.png",
                            width: "50px",
                            height: "50px"
                        },
                        {
                            id: "OSMWood",
                            title: '',
                            thumbnail: "	https://files.ekgis.vn/widget/v1.0.0/assets/image/go-map.png",
                            width: "50px",
                            height: "50px"
                        },]
                    });
                    map.addControl(basemap, 'bottom-left');
                    basemap.on('changeBaseLayer', function (response) {
                        if (response.layer == "OSMStandard") mapOSMStandard.addTo(map);
                        else if (response.layer == "OSMBright") mapOSMBright.addTo(map);
                        else if (response.layer == "OSMNight") mapOSMNight.addTo(map);
                        else if (response.layer == "OSMGray") mapOSMGray.addTo(map);
                        else if (response.layer == "OSMDark") mapOSMDark.addTo(map);
                        else if (response.layer == "OSMWood") mapOSMWood.addTo(map);
                        else if (response.layer == "OSMPirates") mapOSMPirates.addTo(map);
                        else if (response.layer == "OSMPencil") mapOSMPencil.addTo(map);
                    });
                } else if (theme == 2) {
                    mapOSMBright = new ekmapplf.VectorBaseMap('CTM:Bright', api_key);
                    mapOSMGray = new ekmapplf.VectorBaseMap('CTM:Gray', api_key);
                    mapOSMDark = new ekmapplf.VectorBaseMap('CTM:Dark', api_key);
                    mapOSMNight = new ekmapplf.VectorBaseMap('CTM:Night', api_key);
                } else if (theme == 3) {
                    mapOSMBright = new ekmapplf.VectorBaseMap('BDM:Basic', api_key);
                    mapOSMGray = new ekmapplf.VectorBaseMap('BDM:Basic', api_key);
                    mapOSMDark = new ekmapplf.VectorBaseMap('BDM:Basic', api_key);
                    mapOSMNight = new ekmapplf.VectorBaseMap('BDM:Basic', api_key);
                } else if (theme == 4) {
                    mapOSMBright = new ekmapplf.layer.LandUse({ 'apiKey': api_key });
                    mapOSMGray = new ekmapplf.layer.LandUse({ 'apiKey': api_key });
                    mapOSMDark = new ekmapplf.layer.LandUse({ 'apiKey': api_key });
                    mapOSMNight = new ekmapplf.layer.LandUse({ 'apiKey': api_key });
                } else if (theme == 5) {
                    mapOSMBright = new ekmapplf.layer.Zoning({ 'apiKey': api_key });
                    mapOSMGray = new ekmapplf.layer.Zoning({ 'apiKey': api_key });
                    mapOSMDark = new ekmapplf.layer.Zoning({ 'apiKey': api_key });
                    mapOSMNight = new ekmapplf.layer.Zoning({ 'apiKey': api_key });
                }
                switch (styleMap) {
                    case '0':
                        mapOSMStandard.addTo(map);
                        break;
                    case '1':
                        mapOSMBright.addTo(map);
                        break;
                    case '2':
                        mapOSMGray.addTo(map);
                        break;
                    case '3':
                        mapOSMDark.addTo(map);
                        break;
                    case '4':
                        mapOSMNight.addTo(map);
                        break;
                    case '5':
                        mapOSMPencil.addTo(map);
                        break;
                    case '6':
                        mapOSMPirates.addTo(map);
                        break;
                    case '7':
                        mapOSMWood.addTo(map);
                        break;
                    case '8':
                        mapBDM.addTo(map);
                        break;
                }
                if (direction == 1) {
                    var Map_el = document.getElementById('ek_map_admin');
                    var Left_el = document.createElement('div');
                    Left_el.id = 'left';
                    Left_el.className = 'ek-sidebar ek-panel ek-left ek-collapsed';
                    Left_el.innerHTML =
                        `<div class="ek-dr-header"></div>` +
                        `<div class="ek-dr-content ekmap-scrollbar"></div>`;
                    Map_el.appendChild(Left_el);

                    if (document.getElementsByClassName('ekmap-direction').length > 0) {
                        document.getElementsByClassName('ekmap-direction')[0].style.width = $('.ekmap_add_width').val();
                    } else {
                        var El_direct = document.createElement('div');
                        El_direct.className = 'ekmap-direction';
                        El_direct.style.width = $('.ekmap_add_width').val();
                        El_direct.innerHTML =
                            '<div class="ekmap-direction-title">' +
                            '<h3>Chỉ đường</h3>' +
                            '</div>' +
                            '<div class="ekmap-direction-form">' +
                            '<div class="ekmap-direction-form-from">' +
                            '<ul class="ekdrt_ul">' +
                            '<li>' +
                            '<span>Điểm bắt đầu:</span>' +
                            '<div class="input-group">' +
                            '<input class="ek-dr-from" name="ek-dr-from" type="text"placeholder="Chọn điểm bắt đầu"/>' +
                            '<span class="ek-geolocate" name="ek-geolocate" title="Lấy vị trí của bạn">' +
                            '<span class="ek-icon-geolocation" aria-hidden="true"></span>' +
                            '</span>' +
                            '</div>' +
                            '</li>' +
                            '<li>' +
                            '<span>Phương tiện:</span>' +
                            '<select class="ek-vehicle" name="ek-vehicle">' +
                            '<option value="car" selected>Lái xe</option>' +
                            '<option value="bicycle">Xe đạp</option>' +
                            '<option value="foot">Đi bộ</option>' +
                            '</select>' +
                            '</li>' +
                            '</ul>' +
                            '</div>' +
                            '<div class="ekmap-direction-form-to">' +
                            '<ul class="ekdrt_ul">' +
                            '<li >' +
                            '<span>Điểm kết thúc:</span>' +
                            '<span class="ek-swap" name="ek-swap" title="Đảo ngược điểm bắt đầu và điểm kết thúc"><span class="ek-icon-swap" aria-hidden="true"></span></span>' +
                            '<div class="input-group">' +
                            '<input class="ek-dr-to" name="ek-dr-to" type="text" placeholder="Chọn điểm kết thúc"/>' +
                            '<span class="ek-geolocate2" name="ek-geolocate2" title="Lấy vị trí của bạn">' +
                            '<span class="ek-icon-geolocation" aria-hidden="true"></span>' +
                            '</span>' +
                            '</div>' +
                            '</li>' +
                            // '<li style="margin: 5px 0;">'+
                            //     '<span>Đơn vị:</span>'+
                            //     '<select class="ek-units" name="ek-units" style="max-width: unset;border-radius: 5px;margin-top: 5px;border-color: #b1b1b1;">'+
                            //         '<option selected>Kilomet (Km)</option>'+
                            //         '<option>Met (m)</option>'+
                            //     '</select>'+
                            // '</li>'+
                            '</ul>' +
                            '</div>' +
                            '</div>';
                        Map_el.appendChild(El_direct);

                        Map_el.querySelector(".maplibregl-cooperative-gesture-screen").style.bottom='190px';
                        var Ctl_el = Map_el.querySelector(".maplibregl-control-container");
                        Ctl_el.querySelector('.maplibregl-ctrl-bottom-left').style.bottom='190px';
                        Ctl_el.querySelector('.maplibregl-ctrl-bottom-right').style.bottom='190px';

                        autocomplete($('.ek-dr-from')[0]);
                        autocomplete($('.ek-dr-to')[0]);
                        map.setPadding({bottom:100})
                    }

                } else if (direction == 0 || direction == 2) {
                    var Map_el = document.getElementById('ek_map_admin');
                    var El_direct = Map_el.querySelector('.ekmap-direction');
                    if (El_direct) {
                        El_direct.remove();
                        Map_el.querySelector(".maplibregl-cooperative-gesture-screen").style.bottom='0px';
                        var Ctl_el = Map_el.querySelector(".maplibregl-control-container");
                        Ctl_el.querySelector('.maplibregl-ctrl-bottom-left').style.bottom='0px';
                        Ctl_el.querySelector('.maplibregl-ctrl-bottom-right').style.bottom='0px';
                    }
                }
                // Controls
                map.addControl(new maplibregl.NavigationControl(), 'bottom-right');

                var is3DMap = false;
                if (map.getPitch() > 0) is3DMap = true;
                else is3DMap = false;
                var cl = 'maplibregl-terrain2d-control';
                var tl = 'Bản đồ 2D';
                if (!is3DMap) {
                    cl = 'maplibregl-terrain3d-control';
                    tl = 'Bản đồ 3D';
                }
                let btn3D = new ekmapplf.control.Button({
                    icon: 'none',
                    className: cl,
                    tooltip: tl,
                });
                btn3D.on('click', (btn) => {
                    is3DMap = !is3DMap;
                    if (is3DMap) {
                        btn._div.className = btn._div.className.replaceAll(
                            'maplibregl-terrain3d-control',
                            'maplibregl-terrain2d-control'
                        );
                        btn._div.title = 'Bản đồ 2D';
                    }
                    else {
                        btn._div.className = btn._div.className.replaceAll(
                            'maplibregl-terrain2d-control',
                            'maplibregl-terrain3d-control'
                        );
                        btn._div.title = 'Bản đồ 3D';
                    }
                    if (is3DMap) {
                        map.easeTo({ pitch: 60 });
                        map.setLayoutProperty(
                            'building-3d',
                            'visibility',
                            'visible'
                        );
                    } else {
                        map.easeTo({ pitch: 0 });
                        map.setLayoutProperty(
                            'building-3d',
                            'visibility',
                            'none'
                        );
                    }
                });
                map.addControl(btn3D, 'bottom-right');

                geolocate = new maplibregl.GeolocateControl({ positionOptions: { enableHighAccuracy: true }, trackUserLocation: false, showAccuracyCircle:false});
                map.addControl(geolocate, 'bottom-right');
                geolocate.on('geolocate', function (evt) {
                    currentPosition = [evt.coords.longitude, evt.coords.latitude];
                })
                map.addControl(new maplibregl.FullscreenControl(), 'bottom-right');
            }
        }

        var markerClickOnMap, map2, mapOSMStandard2, mapOSMBright2, mapOSMGray2, mapOSMDark2, mapOSMNight2, mapOSMPencil2, mapOSMPirates2, mapOSMWood2, mapBDM2;

        function changeStyleMap2(styleMap, theme, direction) {
            if ($("#ek_map_admin2").length > 0) {
                $('#ek_map_admin2').empty();
                $('#ek_map_admin2').css('width', $('.ekmap_add_width').val());
                $('#ek_map_admin2').css('height', $('.ekmap_add_height').val());
                let lat = $('.ekmap_add_lon').val();
                let lon = $('.ekmap_add_lat').val();
                map2 = new maplibregl.Map({
                    container: 'ek_map_admin2',
                    center: [lat, lon],
                    zoom: $('.ekmap_add_zoom').val(),
                    cooperativeGestures: true,
                    bearing:$('.ekmap_add_bearing').val(),
                    pitch: $('.ekmap_add_pitch').val(),
                });
                map2.on('click', function (evt) {
                    if (markerClickOnMap) markerClickOnMap.remove()         
                    markerClickOnMap = new maplibregl.Marker({
                        color: '#F84C4C', 
                        scale: 0.8,
                        draggable: true,
                    }).setLngLat(evt.lngLat).addTo(map2);
                    onDragEnd();
                    markerClickOnMap.on('dragend', onDragEnd)
                })
                function onDragEnd() {
                    var lngLat = markerClickOnMap.getLngLat();
                    $('.ekmap_add_lon_marker').val(lngLat.lng);
                    $('.ekmap_add_lat_marker').val(lngLat.lat);
                };
                if (!api_key || api_key == "") {
                    var divPur = document.createElement('div');
                    divPur.classList = "container_purchase_key";
                    var btnPur = document.createElement('a');
                    btnPur.target = "_blank";
                    btnPur.href = "https://ekgis.com.vn/contact-map";
                    btnPur.classList = "btn_purchase_key";
                    btnPur.innerHTML = "Mua API KEY để sử dụng";
                    divPur.appendChild(btnPur);
                    document.getElementById("ek_map_admin2").appendChild(divPur);
                    return;
                }
                if (theme == 1) {
                    mapOSMStandard2 = new ekmapplf.VectorBaseMap('OSM:Standard', api_key);
                    mapOSMBright2 = new ekmapplf.VectorBaseMap('OSM:Bright', api_key);
                    mapOSMGray2 = new ekmapplf.VectorBaseMap('OSM:Gray', api_key);
                    mapOSMDark2 = new ekmapplf.VectorBaseMap('OSM:Dark', api_key);
                    mapOSMNight2 = new ekmapplf.VectorBaseMap('OSM:Night', api_key);
                    mapOSMPencil2 = new ekmapplf.VectorBaseMap('OSM:Pencil', api_key);
                    mapOSMPirates2 = new ekmapplf.VectorBaseMap('OSM:Pirates', api_key);
                    mapOSMWood2 = new ekmapplf.VectorBaseMap('OSM:Wood', api_key);
                    mapBDM2 = new ekmapplf.VectorBaseMap('BDM:Basic', api_key);

                    var basemap = new ekmapplf.control.BaseMap({
                        baseLayers: [{
                            id: "OSMStandard",
                            title: '',
                            thumbnail: "https://files.ekgis.vn/widget/v1.0.0/assets/image/map-chuan.png",
                            width: "50px",
                            height: "50px"
                        },
                        {
                            id: "OSMBright",
                            title: '',
                            thumbnail: "	https://files.ekgis.vn/widget/v1.0.0/assets/image/map-sang.png",
                            width: "50px",
                            height: "50px"
                        },
                        {
                            id: "OSMGray",
                            title: '',
                            thumbnail: "	https://files.ekgis.vn/widget/v1.0.0/assets/image/xam-map.png",
                            width: "50px",
                            height: "50px"
                        },
                        {
                            id: "OSMNight",
                            title: '',
                            thumbnail: "	https://files.ekgis.vn/widget/v1.0.0/assets/image/dem-map.png",
                            width: "50px",
                            height: "50px"
                        },
                        {
                            id: "OSMDark",
                            title: '',
                            thumbnail: "	https://files.ekgis.vn/widget/v1.0.0/assets/image/xanhcoban-map.png",
                            width: "50px",
                            height: "50px"
                        },
                        {
                            id: "OSMPencil",
                            title: '',
                            thumbnail: "	https://files.ekgis.vn/widget/v1.0.0/assets/image/chi-map.png",
                            width: "50px",
                            height: "50px"
                        },
                        {
                            id: "OSMPirates",
                            title: '',
                            thumbnail: "	https://files.ekgis.vn/widget/v1.0.0/assets/image/dien-map.png",
                            width: "50px",
                            height: "50px"
                        },
                        {
                            id: "OSMWood",
                            title: '',
                            thumbnail: "	https://files.ekgis.vn/widget/v1.0.0/assets/image/go-map.png",
                            width: "50px",
                            height: "50px"
                        },
                        ]
                    });
                    map2.addControl(basemap, 'bottom-left');
                    basemap.on('changeBaseLayer', function (response) {
                        if (response.layer == "OSMStandard") mapOSMStandard2.addTo(map2);
                        else if (response.layer == "OSMBright") mapOSMBright2.addTo(map2);
                        else if (response.layer == "OSMNight") mapOSMNight2.addTo(map2);
                        else if (response.layer == "OSMGray") mapOSMGray2.addTo(map2);
                        else if (response.layer == "OSMDark") mapOSMDark2.addTo(map2);
                        else if (response.layer == "OSMWood") mapOSMWood2.addTo(map2);
                        else if (response.layer == "OSMPirates") mapOSMPirates2.addTo(map2);
                        else if (response.layer == "OSMPencil") mapOSMPencil2.addTo(map2);
                    });
                } else if (theme == 2) {
                    mapOSMBright2 = new ekmapplf.VectorBaseMap('CTM:Bright', api_key);
                    mapOSMGray2 = new ekmapplf.VectorBaseMap('CTM:Gray', api_key);
                    mapOSMDark2 = new ekmapplf.VectorBaseMap('CTM:Dark', api_key);
                    mapOSMNight2 = new ekmapplf.VectorBaseMap('CTM:Night', api_key);
                } else if (theme == 3) {
                    mapOSMBright2 = new ekmapplf.VectorBaseMap('BDM:Basic', api_key);
                    mapOSMGray2 = new ekmapplf.VectorBaseMap('BDM:Basic', api_key);
                    mapOSMDark2 = new ekmapplf.VectorBaseMap('BDM:Basic', api_key);
                    mapOSMNight2 = new ekmapplf.VectorBaseMap('BDM:Basic', api_key);
                } else if (theme == 4) {
                    mapOSMBright2 = new ekmapplf.layer.LandUse({ 'apiKey': api_key });
                    mapOSMGray2 = new ekmapplf.layer.LandUse({ 'apiKey': api_key });
                    mapOSMDark2 = new ekmapplf.layer.LandUse({ 'apiKey': api_key });
                    mapOSMNight2 = new ekmapplf.layer.LandUse({ 'apiKey': api_key });
                } else if (theme == 5) {
                    mapOSMBright2 = new ekmapplf.layer.Zoning({ 'apiKey': api_key });
                    mapOSMGray2 = new ekmapplf.layer.Zoning({ 'apiKey': api_key });
                    mapOSMDark2 = new ekmapplf.layer.Zoning({ 'apiKey': api_key });
                    mapOSMNight2 = new ekmapplf.layer.Zoning({ 'apiKey': api_key });
                }
                switch (styleMap) {
                    case '0':
                        mapOSMStandard2.addTo(map2);
                        break;
                    case '1':
                        mapOSMBright2.addTo(map2);
                        break;
                    case '2':
                        mapOSMGray2.addTo(map2);
                        break;
                    case '3':
                        mapOSMDark2.addTo(map2);
                        break;
                    case '4':
                        mapOSMNight2.addTo(map2);
                        break;
                    case '5':
                        mapOSMPencil2.addTo(map2);
                        break;
                    case '6':
                        mapOSMPirates2.addTo(map2);
                        break;
                    case '7':
                        mapOSMWood2.addTo(map2);
                        break;
                    case '8':
                        mapBDM2.addTo(map2);
                        break;
                }
                if (direction == 1) {
                    var Map_el = document.getElementById('ek_map_admin2');
                    var Left_el = document.createElement('div');
                    Left_el.id = 'left2';
                    Left_el.className = 'ek-sidebar ek-panel ek-left ek-collapsed';
                    Left_el.innerHTML =
                        `<div class="ek-dr-header"></div>` +
                        `<div class="ek-dr-content ekmap-scrollbar"></div>`;
                    Map_el.appendChild(Left_el);

                    if (document.getElementsByClassName('ekmap-direction2').length > 0) {
                        document.getElementsByClassName('ekmap-direction2')[0].style.width = $('.ekmap_add_width').val();
                    } else {
                        var El_direct = document.createElement('div');
                        El_direct.className = 'ekmap-direction2';
                        El_direct.style.width = $('.ekmap_add_width').val();
                        El_direct.innerHTML =
                            '<div class="ekmap-direction-title">' +
                            '<h3>Chỉ đường</h3>' +
                            '</div>' +
                            '<div class="ekmap-direction-form">' +
                            '<div class="ekmap-direction-form-from">' +
                            '<ul class="ekdrt_ul">' +
                            '<li>' +
                            '<span>Điểm bắt đầu:</span>' +
                            '<div class="input-group">' +
                            '<input class="ek-dr-from" name="ek-dr-from" type="text"placeholder="Chọn điểm bắt đầu"/>' +
                            '<span class="ek-geolocate" name="ek-geolocate" title="Lấy vị trí của bạn">' +
                            '<span class="ek-icon-geolocation" aria-hidden="true"></span>' +
                            '</span>' +
                            '</div>' +
                            '</li>' +
                            '<li>' +
                            '<span>Phương tiện:</span>' +
                            '<select class="ek-vehicle" name="ek-vehicle">' +
                            '<option value="car" selected>Lái xe</option>' +
                            '<option value="bicycle">Xe đạp</option>' +
                            '<option value="foot">Đi bộ</option>' +
                            '</select>' +
                            '</li>' +
                            '</ul>' +
                            '</div>' +
                            '<div class="ekmap-direction-form-to">' +
                            '<ul class="ekdrt_ul">' +
                            '<li >' +
                            '<span>Điểm kết thúc:</span>' +
                            '<span class="ek-swap" name="ek-swap" title="Đảo ngược điểm bắt đầu và điểm kết thúc"><span class="ek-icon-swap" aria-hidden="true"></span></span>' +
                            '<div class="input-group">' +
                            '<input class="ek-dr-to" name="ek-dr-to" type="text" placeholder="Chọn điểm kết thúc"/>' +
                            '<span class="ek-geolocate2" name="ek-geolocate2" title="Lấy vị trí của bạn">' +
                            '<span class="ek-icon-geolocation" aria-hidden="true"></span>' +
                            '</span>' +
                            '</div>' +
                            '</li>' +
                            // '<li style="margin: 5px 0;">'+
                            //     '<span>Đơn vị:</span>'+
                            //     '<select class="ek-units" name="ek-units" style="max-width: unset;border-radius: 5px;margin-top: 5px;border-color: #b1b1b1;">'+
                            //         '<option selected>Kilomet (Km)</option>'+
                            //         '<option>Met (m)</option>'+
                            //     '</select>'+
                            // '</li>'+
                            '</ul>' +
                            '</div>' +
                            '</div>';
                            Map_el.appendChild(El_direct);

                            Map_el.querySelector(".maplibregl-cooperative-gesture-screen").style.bottom='190px';
                            var Ctl_el = Map_el.querySelector(".maplibregl-control-container");
                            Ctl_el.querySelector('.maplibregl-ctrl-bottom-left').style.bottom='190px';
                            Ctl_el.querySelector('.maplibregl-ctrl-bottom-right').style.bottom='190px';
    
                            autocomplete($('.ek-dr-from')[1]);
                            autocomplete($('.ek-dr-to')[1]);

                            map2.setPadding({bottom:100})
                    }
                } else if (direction == 0 || direction == 2) {
                    var Map_el = document.getElementById('ek_map_admin2');
                    var El_direct = Map_el.querySelector('.ekmap-direction2');
                    if (El_direct) {
                        El_direct.remove();
                        Map_el.querySelector(".maplibregl-cooperative-gesture-screen").style.bottom='0px';
                        var Ctl_el = Map_el.querySelector(".maplibregl-control-container");
                        Ctl_el.querySelector('.maplibregl-ctrl-bottom-left').style.bottom='0px';
                        Ctl_el.querySelector('.maplibregl-ctrl-bottom-right').style.bottom='0px';
                    }
                }
                // Control định hướng và zoom
                map2.addControl(new maplibregl.NavigationControl(), 'bottom-right');

                var is3DMap_ = false;
                if (map2.getPitch() > 0) is3DMap_ = true;
                else is3DMap_ = false;
                var cl = 'maplibregl-terrain2d-control';
                var tl = 'Bản đồ 2D';
                if (!is3DMap_) {
                    cl = 'maplibregl-terrain3d-control';
                    tl = 'Bản đồ 3D';
                }
                let btn3D_ = new ekmapplf.control.Button({
                    icon: 'none',
                    className: cl,
                    tooltip: tl,
                });
                btn3D_.on('click', (btn) => {
                    is3DMap_ = !is3DMap_;
                    if (is3DMap_) {
                        btn._div.className = btn._div.className.replaceAll(
                            'maplibregl-terrain3d-control',
                            'maplibregl-terrain2d-control'
                        );
                        btn._div.title = 'Bản đồ 2D';
                    }
                    else {
                        btn._div.className = btn._div.className.replaceAll(
                            'maplibregl-terrain2d-control',
                            'maplibregl-terrain3d-control'
                        );
                        btn._div.title = 'Bản đồ 3D';
                    }
                    if (is3DMap_) {
                        map2.easeTo({ pitch: 60 });
                        map2.setLayoutProperty(
                            'building-3d',
                            'visibility',
                            'visible'
                        );
                    } else {
                        map2.easeTo({ pitch: 0 });
                        map2.setLayoutProperty(
                            'building-3d',
                            'visibility',
                            'none'
                        );
                    }
                });
                map2.addControl(btn3D_, 'bottom-right');

                geolocate2 = new maplibregl.GeolocateControl({ positionOptions: { enableHighAccuracy: true }, trackUserLocation: false, showAccuracyCircle:false});
                map2.addControl(geolocate2, 'bottom-right');
                geolocate2.on('geolocate', function (evt) {
                    currentPosition2 = [evt.coords.longitude, evt.coords.latitude];
                })
                map2.addControl(new maplibregl.FullscreenControl(), 'bottom-right');
            }
        }
        //change tab
        $('.menu_ekmap_add ul li a').on('click', function () {
            if ($('.ekmap_add_title').val() == '') {
                alert("Tiêu đề không được để trống!");
                return false;
            }
            if($('.ekmap_add_lat').val()=="" || $('.ekmap_add_lon').val()=="" ){
                alert("Giá trị tọa độ không được để trống!");
                return false;
            }
            resetInput();
            let index = $(this).parent().index();
            index = parseInt(index) + 1;
            $('.menu_ekmap_add ul li').removeClass('active');
            $(this).parent().addClass('active');
            $('.ekmap_add .item').removeClass('active');
            $('.ekmap_add .item:nth-child(' + index + ')').addClass('active');
            changeStyleMap($('.ekmap_add_type').val(), $('.ekmap_add_theme').val(), $('.ekmap_add_direction').val());
            changeStyleMap2($('.ekmap_add_type').val(), $('.ekmap_add_theme').val(), $('.ekmap_add_direction').val());
            $('.ek-dr-from').val('');
            $('.ek-dr-to').val('');
            $('.ek-vehicle').val('car');
            $('.ekmap_list_marker tbody').empty();
            mapMarkers1.forEach((marker) => marker.remove())
            mapMarkers1 = [];
            mapMarkers2.forEach((marker) => marker.remove())
            mapMarkers2 = [];
            mapMarkers_open1.forEach((marker) => marker.remove())
            mapMarkers_open1 = [];
            mapMarkers_open2.forEach((marker) => marker.remove())
            mapMarkers_open2 = [];
            for (let i = 0; i < arr_markers.length; i++) {
                let class_edit, path_img;
                if (arr_markers[i].check == 1) {
                    class_edit = 'edit_path';
                } else {
                    class_edit = '';
                }
                let svg = '<svg display="block" style="margin: auto;" height="41px" width="27px" viewBox="0 0 27 41"><g fill-rule="nonzero"><g transform="translate(3.0, 29.0)" fill="#000000"><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="10.5" ry="5.25002273"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="10.5" ry="5.25002273"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="9.5" ry="4.77275007"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="8.5" ry="4.29549936"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="7.5" ry="3.81822308"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="6.5" ry="3.34094679"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="5.5" ry="2.86367051"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="4.5" ry="2.38636864"></ellipse></g><g fill="' + arr_markers[i].color + '"><path d="M27,13.5 C27,19.074644 20.250001,27.000002 14.75,34.500002 C14.016665,35.500004 12.983335,35.500004 12.25,34.500002 C6.7499993,27.000002 0,19.222562 0,13.5 C0,6.0441559 6.0441559,0 13.5,0 C20.955844,0 27,6.0441559 27,13.5 Z"></path></g><g opacity="0.25" fill="' + arr_markers[i].color + '"><path d="M13.5,0 C6.0441559,0 0,6.0441559 0,13.5 C0,19.222562 6.7499993,27 12.25,34.5 C13,35.522727 14.016664,35.500004 14.75,34.5 C20.250001,27 27,19.074644 27,13.5 C27,6.0441559 20.955844,0 13.5,0 Z M13.5,1 C20.415404,1 26,6.584596 26,13.5 C26,15.898657 24.495584,19.181431 22.220703,22.738281 C19.945823,26.295132 16.705119,30.142167 13.943359,33.908203 C13.743445,34.180814 13.612715,34.322738 13.5,34.441406 C13.387285,34.322738 13.256555,34.180814 13.056641,33.908203 C10.284481,30.127985 7.4148684,26.314159 5.015625,22.773438 C2.6163816,19.232715 1,15.953538 1,13.5 C1,6.584596 6.584596,1 13.5,1 Z"></path></g><g transform="translate(6.0, 7.0)" fill="#FFFFFF"></g><g transform="translate(8.0, 8.0)"><circle fill="' + arr_markers[i].color + '" opacity="0.25" cx="5.5" cy="5.5" r="5.4999962"></circle><circle fill="#FFFFFF" cx="5.5" cy="5.5" r="5.4999962"></circle></g></g></svg>';
                $('.ekmap_list_marker tbody').prepend('<tr><td>' + arr_markers[i].title + '</td><td data-color="' + arr_markers[i].color + '">' + svg + '</td><td>' + arr_markers[i].phone + '</td><td>' + arr_markers[i].lon + '</td><td>' + arr_markers[i].lat + '</td><td>' + arr_markers[i].link + '</td><td><div class="action"><a href="#" class="edit ' + class_edit + '" data-id="' + arr_markers[i].id + '" data-img="' + arr_markers[i].image + '" data-width="' + arr_markers[i].width + '" data-height="' + arr_markers[i].height + '" data-content="' + arr_markers[i].content + '" data-phone="' + arr_markers[i].phone + '" data-button="' + arr_markers[i].button_text + '" data-btncolor="' + arr_markers[i].button_color + '" data-btnground="' + arr_markers[i].button_ground + '" data-open="' + arr_markers[i].open + '" data-img="' + arr_markers[i].img + '"><i class="fa fa-pencil" aria-hidden="true"></i></a><a href="#" class="remove_fix" data-id="' + arr_markers[i].id + '"><i class="fa fa-trash" aria-hidden="true"></i></a></div></td></tr>');
                let html = '';
                html += '<div class="content_popup_ekmap">';
                if (arr_markers[i].image != '') {
                    html += '<img src="' + arr_markers[i].image + '" alt="' + arr_markers[i].title + '" width="' + arr_markers[i].width + '" height="' + arr_markers[i].height + '" />';
                }
                if (arr_markers[i].title != '') {
                    html += '<h3>' + arr_markers[i].title + '</h3>';
                }
                if (arr_markers[i].content != '') {
                    html += '<p>' + arr_markers[i].content + '</p>';
                }
                if (arr_markers[i].phone != '') {
                    html += '<p><i class="fa fa-phone" aria-hidden="true"></i>\n ' + arr_markers[i].phone + '</p>';
                }
                let style_btn = '';
                if (arr_markers[i].button_color != '') {
                    style_btn += 'color: ' + arr_markers[i].button_color + ';';
                }
                if (arr_markers[i].button_ground != '') {
                    style_btn += 'background-color: ' + arr_markers[i].button_ground + ';';
                }
                if (arr_markers[i].button_text != '') {
                    html += '<p style="display:flex; justify-content: center;"><a href="' + arr_markers[i].link + '" style="' + style_btn + '">' + arr_markers[i].button_text + '</a>';
                }
                if ($('.ekmap_add_direction').val() != 0) {
                    if (arr_markers[i].button_text == '') html += '<p style="display:flex; justify-content: center;">';
                    html += '<a class="ek_routing" style="' + style_btn + '" data-lon="' + arr_markers[i].lon + '" data-lat="' + arr_markers[i].lat + '">Chỉ đường</a>';
                    html += '</p>';
                }
                if ($('.ekmap_add_direction').val() == 0 && arr_markers[i].button_text != '') {
                    html += '</p>';
                }
                html += '</div>';
                const popup = new maplibregl.Popup({ focusAfterOpen: false, closeOnClick: false, offset: 25 }).setHTML(html);
                if (arr_markers[i].lon != '' && arr_markers[i].lat != '') {
                    marker1 = new maplibregl.Marker({ color: arr_markers[i].color })
                        .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                        .setPopup(popup)
                        .addTo(map);
                    marker2 = new maplibregl.Marker({ color: arr_markers[i].color })
                        .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                        .setPopup(popup)
                        .addTo(map2);
                    if (arr_markers[i].open == 1) {
                        const marker_open1 = new maplibregl.Popup({ closeButton:false, focusAfterOpen: false, closeOnClick: false, offset: 25, color: arr_markers[i].color })
                            .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                            .setHTML(html)
                            .addTo(map);

                        const marker_open2 = new maplibregl.Popup({ closeButton:false, focusAfterOpen: false, closeOnClick: false, offset: 25, color: arr_markers[i].color })
                            .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                            .setHTML(html)
                            .addTo(map2);
                        mapMarkers_open1.push(marker_open1);
                        mapMarkers_open2.push(marker_open2);
                    }
                    mapMarkers1.push(marker1);
                    mapMarkers2.push(marker2);
                }
                $('.ekmap_add_list_marker').val(JSON.stringify(arr_markers));
            }
            renderMarker(mapMarkers1);
            renderMarker(mapMarkers2);
            renderPopup(mapMarkers_open1);
            renderPopup(mapMarkers_open2);
            return false;
        });
        //change basemap style
        $('.ekmap_add_type').on('change', function () {
            $('#ek_map_admin').css('width', $('.ekmap_add_width').val());
            $('#ek_map_admin').css('height', $('.ekmap_add_height').val());
            changeStyleMap($('.ekmap_add_type').val(), $('.ekmap_add_theme').val(), $('.ekmap_add_direction').val());
            changeStyleMap2($('.ekmap_add_type').val(), $('.ekmap_add_theme').val(), $('.ekmap_add_direction').val());
            $('.ekmap_list_marker tbody').empty();
            mapMarkers1.forEach((marker) => marker.remove())
            mapMarkers1 = [];
            mapMarkers2.forEach((marker) => marker.remove())
            mapMarkers2 = [];
            mapMarkers_open1.forEach((marker) => marker.remove())
            mapMarkers_open1 = [];
            mapMarkers_open2.forEach((marker) => marker.remove())
            mapMarkers_open2 = [];
            for (let i = 0; i < arr_markers.length; i++) {
                let class_edit, path_img;
                if (arr_markers[i].check == 1) {
                    class_edit = 'edit_path';
                } else {
                    class_edit = '';
                }
                let svg = '<svg display="block" style="margin: auto;" height="41px" width="27px" viewBox="0 0 27 41"><g fill-rule="nonzero"><g transform="translate(3.0, 29.0)" fill="#000000"><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="10.5" ry="5.25002273"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="10.5" ry="5.25002273"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="9.5" ry="4.77275007"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="8.5" ry="4.29549936"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="7.5" ry="3.81822308"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="6.5" ry="3.34094679"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="5.5" ry="2.86367051"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="4.5" ry="2.38636864"></ellipse></g><g fill="' + arr_markers[i].color + '"><path d="M27,13.5 C27,19.074644 20.250001,27.000002 14.75,34.500002 C14.016665,35.500004 12.983335,35.500004 12.25,34.500002 C6.7499993,27.000002 0,19.222562 0,13.5 C0,6.0441559 6.0441559,0 13.5,0 C20.955844,0 27,6.0441559 27,13.5 Z"></path></g><g opacity="0.25" fill="' + arr_markers[i].color + '"><path d="M13.5,0 C6.0441559,0 0,6.0441559 0,13.5 C0,19.222562 6.7499993,27 12.25,34.5 C13,35.522727 14.016664,35.500004 14.75,34.5 C20.250001,27 27,19.074644 27,13.5 C27,6.0441559 20.955844,0 13.5,0 Z M13.5,1 C20.415404,1 26,6.584596 26,13.5 C26,15.898657 24.495584,19.181431 22.220703,22.738281 C19.945823,26.295132 16.705119,30.142167 13.943359,33.908203 C13.743445,34.180814 13.612715,34.322738 13.5,34.441406 C13.387285,34.322738 13.256555,34.180814 13.056641,33.908203 C10.284481,30.127985 7.4148684,26.314159 5.015625,22.773438 C2.6163816,19.232715 1,15.953538 1,13.5 C1,6.584596 6.584596,1 13.5,1 Z"></path></g><g transform="translate(6.0, 7.0)" fill="#FFFFFF"></g><g transform="translate(8.0, 8.0)"><circle fill="' + arr_markers[i].color + '" opacity="0.25" cx="5.5" cy="5.5" r="5.4999962"></circle><circle fill="#FFFFFF" cx="5.5" cy="5.5" r="5.4999962"></circle></g></g></svg>';
                $('.ekmap_list_marker tbody').prepend('<tr><td>' + arr_markers[i].title + '</td><td data-color="' + arr_markers[i].color + '">' + svg + '</td><td>' + arr_markers[i].phone + '</td><td>' + arr_markers[i].lon + '</td><td>' + arr_markers[i].lat + '</td><td>' + arr_markers[i].link + '</td><td><div class="action"><a href="#" class="edit ' + class_edit + '" data-id="' + arr_markers[i].id + '" data-img="' + arr_markers[i].image + '" data-width="' + arr_markers[i].width + '" data-height="' + arr_markers[i].height + '" data-content="' + arr_markers[i].content + '" data-phone="' + arr_markers[i].phone + '" data-button="' + arr_markers[i].button_text + '" data-btncolor="' + arr_markers[i].button_color + '" data-btnground="' + arr_markers[i].button_ground + '" data-open="' + arr_markers[i].open + '" data-img="' + arr_markers[i].img + '"><i class="fa fa-pencil" aria-hidden="true"></i></a><a href="#" class="remove_fix" data-id="' + arr_markers[i].id + '"><i class="fa fa-trash" aria-hidden="true"></i></a></div></td></tr>');
                let html = '';
                html += '<div class="content_popup_ekmap">';
                if (arr_markers[i].image != '') {
                    html += '<img src="' + arr_markers[i].image + '" alt="' + arr_markers[i].title + '" width="' + arr_markers[i].width + '" height="' + arr_markers[i].height + '" />';
                }
                if (arr_markers[i].title != '') {
                    html += '<h3>' + arr_markers[i].title + '</h3>';
                }
                if (arr_markers[i].content != '') {
                    html += '<p>' + arr_markers[i].content + '</p>';
                }
                if (arr_markers[i].phone != '') {
                    html += '<p><i class="fa fa-phone" aria-hidden="true"></i>\n ' + arr_markers[i].phone + '</p>';
                }
                let style_btn = '';
                if (arr_markers[i].button_color != '') {
                    style_btn += 'color: ' + arr_markers[i].button_color + ';';
                }
                if (arr_markers[i].button_ground != '') {
                    style_btn += 'background-color: ' + arr_markers[i].button_ground + ';';
                }
                if (arr_markers[i].button_text != '') {
                    html += '<p style="display:flex; justify-content: center;"><a href="' + arr_markers[i].link + '" style="' + style_btn + '">' + arr_markers[i].button_text + '</a>';
                }
                if ($('.ekmap_add_direction').val() != 0) {
                    if (arr_markers[i].button_text == '') html += '<p style="display:flex; justify-content: center;">';
                    html += '<a class="ek_routing" style="' + style_btn + '" data-lon="' + arr_markers[i].lon + '" data-lat="' + arr_markers[i].lat + '">Chỉ đường</a>';
                    html += '</p>';
                }
                if ($('.ekmap_add_direction').val() == 0 && arr_markers[i].button_text != '') {
                    html += '</p>';
                }
                html += '</div>';
                const popup = new maplibregl.Popup({ focusAfterOpen: false, closeOnClick: false, offset: 25 }).setHTML(html);
                if (arr_markers[i].lon != '' && arr_markers[i].lat != '') {
                    marker1 = new maplibregl.Marker({ color: arr_markers[i].color })
                        .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                        .setPopup(popup)
                        .addTo(map);
                    marker2 = new maplibregl.Marker({ color: arr_markers[i].color })
                        .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                        .setPopup(popup)
                        .addTo(map2);
                    if (arr_markers[i].open == 1) {
                        const marker_open1 = new maplibregl.Popup({ closeButton:false, focusAfterOpen: false, closeOnClick: false, offset: 25, color: arr_markers[i].color })
                            .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                            .setHTML(html)
                            .addTo(map);

                        const marker_open2 = new maplibregl.Popup({ closeButton:false, focusAfterOpen: false, closeOnClick: false, offset: 25, color: arr_markers[i].color })
                            .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                            .setHTML(html)
                            .addTo(map2);
                        mapMarkers_open1.push(marker_open1);
                        mapMarkers_open2.push(marker_open2);
                    }
                    mapMarkers1.push(marker1);
                    mapMarkers2.push(marker2);
                }
                $('.ekmap_add_list_marker').val(JSON.stringify(arr_markers));
            }
            renderMarker(mapMarkers1);
            renderMarker(mapMarkers2);
            renderPopup(mapMarkers_open1);
            renderPopup(mapMarkers_open2);
        });

        //change map config
        $('.ekmap_add_theme,.ekmap_add_width,.ekmap_add_height,.ekmap_add_zoom,.ekmap_add_lat,.ekmap_add_lon,.ekmap_add_direction,.ekmap_add_pitch,.ekmap_add_bearing').on('change', function () {
            // ktra gia tri nhap
            if( parseInt($('.ekmap_add_lon').val())> 180 || parseInt($('.ekmap_add_lon').val()) < -180 || $('.ekmap_add_lon').val()=="" ){
                alert("Giá trị tọa độ không hợp lệ!");
                // $('.storelocator_ek_add_lon').val('105');
                return false;
            }
            if( parseInt($('.ekmap_add_lat').val()) < -90 || parseInt($('.ekmap_add_lat').val()) > 90 || $('.ekmap_add_lat').val()=="" ){
                alert("Giá trị tọa độ không hợp lệ!");
                // $('.storelocator_ek_add_lat').val('17');
                return false;
            }
            var ArrUnits=['em', 'ex','%', 'px', 'cm', 'mm', 'in', 'pt', 'pc','ch','rem','vh', 'vw','vmin','vmax'];
            var widthVal = $('.ekmap_add_width').val();
            var Wlength = widthVal.split("").length;
            if (widthVal.substr(Wlength-1) =='%') checkVal(widthVal.substr(0,Wlength-1));
            else if (widthVal.substr(Wlength-2) =='px') checkVal(widthVal.substr(0,Wlength-2));
            else if (widthVal.substr(Wlength-2) =='vh') checkVal(widthVal.substr(0,Wlength-2));
            else if (widthVal.substr(Wlength-2) =='vw') checkVal(widthVal.substr(0,Wlength-2));
            else if (widthVal.substr(Wlength-2) =='em') checkVal(widthVal.substr(0,Wlength-2));
            else if (widthVal.substr(Wlength-3) =='rem') checkVal(widthVal.substr(0,Wlength-3));
            else {
                alert("Giá trị không hợp lệ!");
                return false;
            }
            var heightVal = $('.ekmap_add_height').val();
            var Hlength = heightVal.split("").length;
            if (heightVal.substr(Hlength-1) =='%') checkVal(heightVal.substr(0,Hlength-1));
            else if (heightVal.substr(Hlength-2) =='px') checkVal(heightVal.substr(0,Hlength-2));
            else if (heightVal.substr(Hlength-2) =='vh') checkVal(heightVal.substr(0,Hlength-2));
            else if (heightVal.substr(Hlength-2) =='vw') checkVal(heightVal.substr(0,Hlength-2));
            else if (heightVal.substr(Hlength-2) =='em') checkVal(heightVal.substr(0,Hlength-2));
            else if (heightVal.substr(Hlength-3) =='rem') checkVal(heightVal.substr(0,Hlength-3));
            else {
                alert("Giá trị không hợp lệ!");
                return false;
            }
            function checkVal(val){
                if (isNaN(val)){
                    alert("Giá trị không hợp lệ!");
                    return false;
                }
            }
            
            $('#ek_map_admin2').css('width', $('.ekmap_add_width').val());
            $('#ek_map_admin2').css('height', $('.ekmap_add_height').val());
            changeStyleMap($('.ekmap_add_type').val(), $('.ekmap_add_theme').val(), $('.ekmap_add_direction').val());
            changeStyleMap2($('.ekmap_add_type').val(), $('.ekmap_add_theme').val(), $('.ekmap_add_direction').val());
            $('.ekmap_list_marker tbody').empty();
            mapMarkers1.forEach((marker) => marker.remove())
            mapMarkers1 = [];
            mapMarkers2.forEach((marker) => marker.remove())
            mapMarkers2 = [];
            mapMarkers_open1.forEach((marker) => marker.remove())
            mapMarkers_open1 = [];
            mapMarkers_open2.forEach((marker) => marker.remove())
            mapMarkers_open2 = [];
            for (let i = 0; i < arr_markers.length; i++) {
                let class_edit, path_img;
                if (arr_markers[i].check == 1) {
                    class_edit = 'edit_path';
                } else {
                    class_edit = '';
                }
                let svg = '<svg display="block" style="margin: auto;" height="41px" width="27px" viewBox="0 0 27 41"><g fill-rule="nonzero"><g transform="translate(3.0, 29.0)" fill="#000000"><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="10.5" ry="5.25002273"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="10.5" ry="5.25002273"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="9.5" ry="4.77275007"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="8.5" ry="4.29549936"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="7.5" ry="3.81822308"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="6.5" ry="3.34094679"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="5.5" ry="2.86367051"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="4.5" ry="2.38636864"></ellipse></g><g fill="' + arr_markers[i].color + '"><path d="M27,13.5 C27,19.074644 20.250001,27.000002 14.75,34.500002 C14.016665,35.500004 12.983335,35.500004 12.25,34.500002 C6.7499993,27.000002 0,19.222562 0,13.5 C0,6.0441559 6.0441559,0 13.5,0 C20.955844,0 27,6.0441559 27,13.5 Z"></path></g><g opacity="0.25" fill="' + arr_markers[i].color + '"><path d="M13.5,0 C6.0441559,0 0,6.0441559 0,13.5 C0,19.222562 6.7499993,27 12.25,34.5 C13,35.522727 14.016664,35.500004 14.75,34.5 C20.250001,27 27,19.074644 27,13.5 C27,6.0441559 20.955844,0 13.5,0 Z M13.5,1 C20.415404,1 26,6.584596 26,13.5 C26,15.898657 24.495584,19.181431 22.220703,22.738281 C19.945823,26.295132 16.705119,30.142167 13.943359,33.908203 C13.743445,34.180814 13.612715,34.322738 13.5,34.441406 C13.387285,34.322738 13.256555,34.180814 13.056641,33.908203 C10.284481,30.127985 7.4148684,26.314159 5.015625,22.773438 C2.6163816,19.232715 1,15.953538 1,13.5 C1,6.584596 6.584596,1 13.5,1 Z"></path></g><g transform="translate(6.0, 7.0)" fill="#FFFFFF"></g><g transform="translate(8.0, 8.0)"><circle fill="' + arr_markers[i].color + '" opacity="0.25" cx="5.5" cy="5.5" r="5.4999962"></circle><circle fill="#FFFFFF" cx="5.5" cy="5.5" r="5.4999962"></circle></g></g></svg>';
                $('.ekmap_list_marker tbody').prepend('<tr><td>' + arr_markers[i].title + '</td><td data-color="' + arr_markers[i].color + '">' + svg + '</td><td>' + arr_markers[i].phone + '</td><td>' + arr_markers[i].lon + '</td><td>' + arr_markers[i].lat + '</td><td>' + arr_markers[i].link + '</td><td><div class="action"><a href="#" class="edit ' + class_edit + '" data-id="' + arr_markers[i].id + '" data-img="' + arr_markers[i].image + '" data-width="' + arr_markers[i].width + '" data-height="' + arr_markers[i].height + '" data-content="' + arr_markers[i].content + '" data-phone="' + arr_markers[i].phone + '" data-button="' + arr_markers[i].button_text + '" data-btncolor="' + arr_markers[i].button_color + '" data-btnground="' + arr_markers[i].button_ground + '" data-open="' + arr_markers[i].open + '" data-img="' + arr_markers[i].img + '"><i class="fa fa-pencil" aria-hidden="true"></i></a><a href="#" class="remove_fix" data-id="' + arr_markers[i].id + '"><i class="fa fa-trash" aria-hidden="true"></i></a></div></td></tr>');
                let html = '';
                html += '<div class="content_popup_ekmap">';
                if (arr_markers[i].image != '') {
                    html += '<img src="' + arr_markers[i].image + '" alt="' + arr_markers[i].title + '" width="' + arr_markers[i].width + '" height="' + arr_markers[i].height + '" />';
                }
                if (arr_markers[i].title != '') {
                    html += '<h3>' + arr_markers[i].title + '</h3>';
                }
                if (arr_markers[i].content != '') {
                    html += '<p>' + arr_markers[i].content + '</p>';
                }
                if (arr_markers[i].phone != '') {
                    html += '<p><i class="fa fa-phone" aria-hidden="true"></i>\n ' + arr_markers[i].phone + '</p>';
                }
                let style_btn = '';
                if (arr_markers[i].button_color != '') {
                    style_btn += 'color: ' + arr_markers[i].button_color + ';';
                }
                if (arr_markers[i].button_ground != '') {
                    style_btn += 'background-color: ' + arr_markers[i].button_ground + ';';
                }
                if (arr_markers[i].button_text != '') {
                    html += '<p style="display:flex; justify-content: center;"><a href="' + arr_markers[i].link + '" style="' + style_btn + '">' + arr_markers[i].button_text + '</a>';
                }
                if ($('.ekmap_add_direction').val() != 0) {
                    if (arr_markers[i].button_text == '') html += '<p style="display:flex; justify-content: center;">';
                    html += '<a class="ek_routing" style="' + style_btn + '" data-lon="' + arr_markers[i].lon + '" data-lat="' + arr_markers[i].lat + '">Chỉ đường</a>';
                    html += '</p>';
                }
                if ($('.ekmap_add_direction').val() == 0 && arr_markers[i].button_text != '') {
                    html += '</p>';
                }
                html += '</div>';
                const popup = new maplibregl.Popup({ focusAfterOpen: false, closeOnClick: false, offset: 25 }).setHTML(html);
                if (arr_markers[i].lon != '' && arr_markers[i].lat != '') {
                    marker1 = new maplibregl.Marker({ color: arr_markers[i].color })
                        .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                        .setPopup(popup)
                        .addTo(map);
                    marker2 = new maplibregl.Marker({ color: arr_markers[i].color })
                        .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                        .setPopup(popup)
                        .addTo(map2);
                    if (arr_markers[i].open == 1) {
                        const marker_open1 = new maplibregl.Popup({closeButton:false, focusAfterOpen: false, closeOnClick: false, offset: 25, color: arr_markers[i].color })
                            .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                            .setHTML(html)
                            .addTo(map);

                        const marker_open2 = new maplibregl.Popup({closeButton:false, focusAfterOpen: false, closeOnClick: false, offset: 25, color: arr_markers[i].color })
                            .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                            .setHTML(html)
                            .addTo(map2);
                        mapMarkers_open1.push(marker_open1);
                        mapMarkers_open2.push(marker_open2);
                    }
                    mapMarkers1.push(marker1);
                    mapMarkers2.push(marker2);
                }
                $('.ekmap_add_list_marker').val(JSON.stringify(arr_markers));
            }
            renderMarker(mapMarkers1);
            renderMarker(mapMarkers2);
            renderPopup(mapMarkers_open1);
            renderPopup(mapMarkers_open2);
        });

        //on load
        $('#ek_map_admin').css('width', $('.ekmap_add_width').val());
        $('#ek_map_admin').css('height', $('.ekmap_add_height').val());
        changeStyleMap($('.ekmap_add_type').val(), $('.ekmap_add_theme').val(), $('.ekmap_add_direction').val());
        changeStyleMap2($('.ekmap_add_type').val(), $('.ekmap_add_theme').val(), $('.ekmap_add_direction').val());
        $('.ekmap_list_marker tbody').empty();
        mapMarkers1.forEach((marker) => marker.remove())
        mapMarkers1 = [];
        mapMarkers2.forEach((marker) => marker.remove())
        mapMarkers2 = [];
        mapMarkers_open1.forEach((marker) => marker.remove())
        mapMarkers_open1 = [];
        mapMarkers_open2.forEach((marker) => marker.remove())
        mapMarkers_open2 = [];
        for (let i = 0; i < arr_markers.length; i++) {
            let class_edit, path_img;
            if (arr_markers[i].check == 1) {
                class_edit = 'edit_path';
            } else {
                class_edit = '';
            }
            let svg = '<svg display="block" style="margin: auto;" height="41px" width="27px" viewBox="0 0 27 41"><g fill-rule="nonzero"><g transform="translate(3.0, 29.0)" fill="#000000"><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="10.5" ry="5.25002273"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="10.5" ry="5.25002273"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="9.5" ry="4.77275007"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="8.5" ry="4.29549936"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="7.5" ry="3.81822308"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="6.5" ry="3.34094679"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="5.5" ry="2.86367051"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="4.5" ry="2.38636864"></ellipse></g><g fill="' + arr_markers[i].color + '"><path d="M27,13.5 C27,19.074644 20.250001,27.000002 14.75,34.500002 C14.016665,35.500004 12.983335,35.500004 12.25,34.500002 C6.7499993,27.000002 0,19.222562 0,13.5 C0,6.0441559 6.0441559,0 13.5,0 C20.955844,0 27,6.0441559 27,13.5 Z"></path></g><g opacity="0.25" fill="' + arr_markers[i].color + '"><path d="M13.5,0 C6.0441559,0 0,6.0441559 0,13.5 C0,19.222562 6.7499993,27 12.25,34.5 C13,35.522727 14.016664,35.500004 14.75,34.5 C20.250001,27 27,19.074644 27,13.5 C27,6.0441559 20.955844,0 13.5,0 Z M13.5,1 C20.415404,1 26,6.584596 26,13.5 C26,15.898657 24.495584,19.181431 22.220703,22.738281 C19.945823,26.295132 16.705119,30.142167 13.943359,33.908203 C13.743445,34.180814 13.612715,34.322738 13.5,34.441406 C13.387285,34.322738 13.256555,34.180814 13.056641,33.908203 C10.284481,30.127985 7.4148684,26.314159 5.015625,22.773438 C2.6163816,19.232715 1,15.953538 1,13.5 C1,6.584596 6.584596,1 13.5,1 Z"></path></g><g transform="translate(6.0, 7.0)" fill="#FFFFFF"></g><g transform="translate(8.0, 8.0)"><circle fill="' + arr_markers[i].color + '" opacity="0.25" cx="5.5" cy="5.5" r="5.4999962"></circle><circle fill="#FFFFFF" cx="5.5" cy="5.5" r="5.4999962"></circle></g></g></svg>';
            $('.ekmap_list_marker tbody').prepend('<tr><td>' + arr_markers[i].title + '</td><td data-color="' + arr_markers[i].color + '">' + svg + '</td><td>' + arr_markers[i].phone + '</td><td>' + arr_markers[i].lon + '</td><td>' + arr_markers[i].lat + '</td><td>' + arr_markers[i].link + '</td><td><div class="action"><a href="#" class="edit ' + class_edit + '" data-id="' + arr_markers[i].id + '" data-img="' + arr_markers[i].image + '" data-width="' + arr_markers[i].width + '" data-height="' + arr_markers[i].height + '" data-content="' + arr_markers[i].content + '" data-phone="' + arr_markers[i].phone + '" data-button="' + arr_markers[i].button_text + '" data-btncolor="' + arr_markers[i].button_color + '" data-btnground="' + arr_markers[i].button_ground + '" data-open="' + arr_markers[i].open + '" data-img="' + arr_markers[i].img + '"><i class="fa fa-pencil" aria-hidden="true"></i></a><a href="#" class="remove_fix" data-id="' + arr_markers[i].id + '"><i class="fa fa-trash" aria-hidden="true"></i></a></div></td></tr>');
            let html = '';
            html += '<div class="content_popup_ekmap">';
            if (arr_markers[i].image != '') {
                html += '<img src="' + arr_markers[i].image + '" alt="' + arr_markers[i].title + '" width="' + arr_markers[i].width + '" height="' + arr_markers[i].height + '" />';
            }
            if (arr_markers[i].title != '') {
                html += '<h3>' + arr_markers[i].title + '</h3>';
            }
            if (arr_markers[i].content != '') {
                html += '<p>' + arr_markers[i].content + '</p>';
            }
            if (arr_markers[i].phone != '') {
                html += '<p><i class="fa fa-phone" aria-hidden="true"></i>\n ' + arr_markers[i].phone + '</p>';
            }
            let style_btn = '';
            if (arr_markers[i].button_color != '') {
                style_btn += 'color: ' + arr_markers[i].button_color + ';';
            }
            if (arr_markers[i].button_ground != '') {
                style_btn += 'background-color: ' + arr_markers[i].button_ground + ';';
            }
            if (arr_markers[i].button_text != '') {
                html += '<p style="display:flex; justify-content: center;"><a href="' + arr_markers[i].link + '" style="' + style_btn + '">' + arr_markers[i].button_text + '</a>';
            }
            if ($('.ekmap_add_direction').val() != 0) {
                if (arr_markers[i].button_text == '') html += '<p style="display:flex; justify-content: center;">';
                html += '<a class="ek_routing" style="' + style_btn + '" data-lon="' + arr_markers[i].lon + '" data-lat="' + arr_markers[i].lat + '">Chỉ đường</a>';
                html += '</p>';
            }
            if ($('.ekmap_add_direction').val() == 0 && arr_markers[i].button_text != '') {
                html += '</p>';
            }
            html += '</div>';
            const popup = new maplibregl.Popup({ focusAfterOpen: false, closeOnClick: false, offset: 25 }).setHTML(html);
            if (arr_markers[i].lon != '' && arr_markers[i].lat != '') {
                marker1 = new maplibregl.Marker({ color: arr_markers[i].color })
                    .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                    .setPopup(popup)
                    .addTo(map);
                marker2 = new maplibregl.Marker({ color: arr_markers[i].color })
                    .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                    .setPopup(popup)
                    .addTo(map2);
                if (arr_markers[i].open == 1) {
                    const marker_open1 = new maplibregl.Popup({closeButton:false, focusAfterOpen: false, closeOnClick: false, offset: 25, color: arr_markers[i].color })
                        .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                        .setHTML(html)
                        .addTo(map);

                    const marker_open2 = new maplibregl.Popup({closeButton:false, focusAfterOpen: false, closeOnClick: false, offset: 25, color: arr_markers[i].color })
                        .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                        .setHTML(html)
                        .addTo(map2);
                    mapMarkers_open1.push(marker_open1);
                    mapMarkers_open2.push(marker_open2);
                }
                mapMarkers1.push(marker1);
                mapMarkers2.push(marker2);
            }
        }
        renderMarker(mapMarkers1);
        renderMarker(mapMarkers2);
        renderPopup(mapMarkers_open1);
        renderPopup(mapMarkers_open2);
        $('.ekmap_add_list_marker').val(JSON.stringify(arr_markers));

        //add marker
        $('.btn_add_marker').on('click', function () {
            if ($('.ekmap_add_title_marker').val() == '') {
                alert("Tiêu đề không được để trống!");
                return false;
            }
            let content_;
            let editor = tinyMCE.get('ekmap_add_content');
            if (editor) {
                // Ok, the active tab is Visual
                content_ = editor.getContent();
            } else {
                // The active tab is HTML, so just query the textarea
                content_ = $('#ekmap_add_content').val();
            }
            if (content_.length>50){
                alert("Mô tả tối đa 40 ký tự!");
                return false;
            }
            if($('.ekmap_add_lat_marker').val()=="" || $('.ekmap_add_lon_marker').val()=="" ){
                alert("Giá trị tọa độ không được để trống!");
                return false;
            }
            if($('.ekmap_img_icon').attr('src')!=""){
                if($('.ekmap_add_width_marker').val()=="" || $('.ekmap_add_height_marker').val()=="" ){
                    alert("Độ rộng, Độ cao bản đồ không được để trống!");
                    return false;
                }
                var ArrUnits=['em', 'ex','%', 'px', 'cm', 'mm', 'in', 'pt', 'pc','ch','rem','vh', 'vw','vmin','vmax'];
                var widthVal = $('.ekmap_add_width_marker').val();
                var Wlength = widthVal.split("").length;
                if (widthVal.substr(Wlength-1) =='%') checkVal(widthVal.substr(0,Wlength-1));
                else if (widthVal.substr(Wlength-2) =='px') checkVal(widthVal.substr(0,Wlength-2));
                else if (widthVal.substr(Wlength-2) =='vh') checkVal(widthVal.substr(0,Wlength-2));
                else if (widthVal.substr(Wlength-2) =='vw') checkVal(widthVal.substr(0,Wlength-2));
                else if (widthVal.substr(Wlength-2) =='em') checkVal(widthVal.substr(0,Wlength-2));
                else if (widthVal.substr(Wlength-3) =='rem') checkVal(widthVal.substr(0,Wlength-3));
                else {
                    alert("Giá trị Độ rộng, Độ cao không hợp lệ!");
                    return false;
                }
                var heightVal = $('.ekmap_add_height_marker').val();
                var Hlength = heightVal.split("").length;
                if (heightVal.substr(Hlength-1) =='%') checkVal(heightVal.substr(0,Hlength-1));
                else if (heightVal.substr(Hlength-2) =='px') checkVal(heightVal.substr(0,Hlength-2));
                else if (heightVal.substr(Hlength-2) =='vh') checkVal(heightVal.substr(0,Hlength-2));
                else if (heightVal.substr(Hlength-2) =='vw') checkVal(heightVal.substr(0,Hlength-2));
                else if (heightVal.substr(Hlength-2) =='em') checkVal(heightVal.substr(0,Hlength-2));
                else if (heightVal.substr(Hlength-3) =='rem') checkVal(heightVal.substr(0,Hlength-3));
                else {
                    alert("Giá trị Độ rộng, Độ cao không hợp lệ!");
                    return false;
                }
                function checkVal(val){
                    if (isNaN(val)){
                        alert("Giá trị Độ rộng, Độ cao không hợp lệ!");
                        return false;
                    }
                }
            }
            if($('.ekmap_add_number_marker').val()=="" ){
                alert("Số điện thoại không được để trống!");
                return false;
            }
            if($('.ekmap_add_link_marker').val()!="" &&$('.ekmap_add_title_btn_marker').val()==""){
                alert("Tiêu đề nút không được để trống!");
                return false;
            }
            if($('.ekmap_add_link_marker').val()=="" &&$('.ekmap_add_title_btn_marker').val()!=""){
                alert("Liên kết không được để trống!");
                return false;
            }
            $('#ek_map_admin').css('width', $('.ekmap_add_width').val());
            $('#ek_map_admin').css('height', $('.ekmap_add_height').val());
            changeStyleMap($('.ekmap_add_type').val(), $('.ekmap_add_theme').val(), $('.ekmap_add_direction').val());
            changeStyleMap2($('.ekmap_add_type').val(), $('.ekmap_add_theme').val(), $('.ekmap_add_direction').val());
            const d = new Date();
            let time = d.getTime();

            arr_markers.push({
                title: $('.ekmap_add_title_marker').val(),
                content: content_,
                color: $('.ekmap_add_color_marker').val(),
                image: $('.ekmap_img_icon').attr('src'),
                width: $('.ekmap_add_width_marker').val(),
                height: $('.ekmap_add_height_marker').val(),
                phone: $('.ekmap_add_number_marker').val(),
                lon: $('.ekmap_add_lon_marker').val(),
                lat: $('.ekmap_add_lat_marker').val(),
                button_text: $('.ekmap_add_title_btn_marker').val(),
                button_color: $('.ekmap_add_title_btn_color_marker').val(),
                button_ground: $('.ekmap_add_title_btn_backgroud_marker').val(),
                link: $('.ekmap_add_link_marker').val(),
                id: time,
                open: $('.ekmap_add_open_marker').val(),
                check: 0
            });

            $('.ekmap_list_marker tbody').empty();
            mapMarkers1.forEach((marker) => marker.remove())
            mapMarkers1 = [];
            mapMarkers2.forEach((marker) => marker.remove())
            mapMarkers2 = [];
            mapMarkers_open1.forEach((marker) => marker.remove())
            mapMarkers_open1 = [];
            mapMarkers_open2.forEach((marker) => marker.remove())
            mapMarkers_open2 = [];
            for (let i = 0; i < arr_markers.length; i++) {
                let class_edit, class_remove, path_img;
                if (arr_markers[i].check === 1) {
                    class_edit = 'edit_path';
                    class_remove = 'remove_edit';
                } else {
                    class_edit = '';
                    class_remove = 'remove';
                }
                let svg = '<svg display="block" style="margin: auto;" height="41px" width="27px" viewBox="0 0 27 41"><g fill-rule="nonzero"><g transform="translate(3.0, 29.0)" fill="#000000"><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="10.5" ry="5.25002273"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="10.5" ry="5.25002273"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="9.5" ry="4.77275007"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="8.5" ry="4.29549936"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="7.5" ry="3.81822308"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="6.5" ry="3.34094679"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="5.5" ry="2.86367051"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="4.5" ry="2.38636864"></ellipse></g><g fill="' + arr_markers[i].color + '"><path d="M27,13.5 C27,19.074644 20.250001,27.000002 14.75,34.500002 C14.016665,35.500004 12.983335,35.500004 12.25,34.500002 C6.7499993,27.000002 0,19.222562 0,13.5 C0,6.0441559 6.0441559,0 13.5,0 C20.955844,0 27,6.0441559 27,13.5 Z"></path></g><g opacity="0.25" fill="' + arr_markers[i].color + '"><path d="M13.5,0 C6.0441559,0 0,6.0441559 0,13.5 C0,19.222562 6.7499993,27 12.25,34.5 C13,35.522727 14.016664,35.500004 14.75,34.5 C20.250001,27 27,19.074644 27,13.5 C27,6.0441559 20.955844,0 13.5,0 Z M13.5,1 C20.415404,1 26,6.584596 26,13.5 C26,15.898657 24.495584,19.181431 22.220703,22.738281 C19.945823,26.295132 16.705119,30.142167 13.943359,33.908203 C13.743445,34.180814 13.612715,34.322738 13.5,34.441406 C13.387285,34.322738 13.256555,34.180814 13.056641,33.908203 C10.284481,30.127985 7.4148684,26.314159 5.015625,22.773438 C2.6163816,19.232715 1,15.953538 1,13.5 C1,6.584596 6.584596,1 13.5,1 Z"></path></g><g transform="translate(6.0, 7.0)" fill="#FFFFFF"></g><g transform="translate(8.0, 8.0)"><circle fill="' + arr_markers[i].color + '" opacity="0.25" cx="5.5" cy="5.5" r="5.4999962"></circle><circle fill="#FFFFFF" cx="5.5" cy="5.5" r="5.4999962"></circle></g></g></svg>';
                $('.ekmap_list_marker tbody').prepend('<tr><td>' + arr_markers[i].title + '</td><td data-color="' + arr_markers[i].color + '">' + svg + '</td><td>' + arr_markers[i].phone + '</td><td>' + arr_markers[i].lon + '</td><td>' + arr_markers[i].lat + '</td><td>' + arr_markers[i].link + '</td><td><div class="action"><a href="#" class="edit ' + class_edit + '" data-id="' + arr_markers[i].id + '" data-img="' + arr_markers[i].image + '" data-width="' + arr_markers[i].width + '" data-height="' + arr_markers[i].height + '" data-content="' + arr_markers[i].content + '" data-phone="' + arr_markers[i].phone + '" data-button="' + arr_markers[i].button_text + '" data-btncolor="' + arr_markers[i].button_color + '" data-btnground="' + arr_markers[i].button_ground + '" data-open="' + arr_markers[i].open + '" data-img="' + arr_markers[i].img + '"><i class="fa fa-pencil" aria-hidden="true"></i></a><a href="#" class="' + class_remove + '" data-id="' + arr_markers[i].id + '"><i class="fa fa-trash" aria-hidden="true"></i></a></div></td></tr>');
                let html = '';
                html += '<div class="content_popup_ekmap">';
                if (arr_markers[i].image != '') {
                    html += '<img src="' + arr_markers[i].image + '" alt="' + arr_markers[i].title + '" width="' + arr_markers[i].width + '" height="' + arr_markers[i].height + '" />';
                }
                if (arr_markers[i].title != '') {
                    html += '<h3>' + arr_markers[i].title + '</h3>';
                }
                if (arr_markers[i].content != '') {
                    html += '<p>' + arr_markers[i].content + '</p>';
                }
                if (arr_markers[i].phone != '') {
                    html += '<p><i class="fa fa-phone" aria-hidden="true"></i>\n ' + arr_markers[i].phone + '</p>';
                }
                let style_btn = '';
                if (arr_markers[i].button_color != '') {
                    style_btn += 'color: ' + arr_markers[i].button_color + ';';
                }
                if (arr_markers[i].button_ground != '') {
                    style_btn += 'background-color: ' + arr_markers[i].button_ground + ';';
                }
                if (arr_markers[i].button_text != '') {
                    html += '<p style="display:flex; justify-content: center;"><a href="' + arr_markers[i].link + '" style="' + style_btn + '">' + arr_markers[i].button_text + '</a>';
                }
                if ($('.ekmap_add_direction').val() != 0) {
                    if (arr_markers[i].button_text == '') html += '<p style="display:flex; justify-content: center;">';
                    html += '<a class="ek_routing" style="' + style_btn + '" data-lon="' + arr_markers[i].lon + '" data-lat="' + arr_markers[i].lat + '">Chỉ đường</a>';
                    html += '</p>';
                }
                if ($('.ekmap_add_direction').val() == 0 && arr_markers[i].button_text != '') {
                    html += '</p>';
                }
                html += '</div>';
                const popup = new maplibregl.Popup({ focusAfterOpen: false, closeOnClick: false, offset: 25 }).setHTML(html);
                if (arr_markers[i].lon != '' && arr_markers[i].lat != '') {
                    marker1 = new maplibregl.Marker({ color: arr_markers[i].color })
                        .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                        .setPopup(popup)
                        .addTo(map);
                    marker2 = new maplibregl.Marker({ color: arr_markers[i].color })
                        .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                        .setPopup(popup)
                        .addTo(map2);
                    if (arr_markers[i].open == 1) {
                        const marker_open1 = new maplibregl.Popup({closeButton:false, focusAfterOpen: false, closeOnClick: false, offset: 25, color: arr_markers[i].color })
                            .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                            .setHTML(html)
                            .addTo(map);

                        const marker_open2 = new maplibregl.Popup({ closeButton:false,focusAfterOpen: false, closeOnClick: false, offset: 25, color: arr_markers[i].color })
                            .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                            .setHTML(html)
                            .addTo(map2);
                        mapMarkers_open1.push(marker_open1);
                        mapMarkers_open2.push(marker_open2);
                    }
                    mapMarkers1.push(marker1);
                    mapMarkers2.push(marker2);
                }
            }
            renderMarker(mapMarkers1);
            renderMarker(mapMarkers2);
            renderPopup(mapMarkers_open1);
            renderPopup(mapMarkers_open2);
            $('.ekmap_add_list_marker').val(JSON.stringify(arr_markers));
            let json_data = arr_markers;
            console.log(Object.entries(json_data));
            //console.log(arr_markers);
            resetInput();

            if(markerClickOnMap)markerClickOnMap.remove() ;
            return false;
        });

        //remove object marker
        $('.ekmap_list.ekmap_add_fix table tbody,.ekmap_list.ekmap_edit_fix table tbody').on('click', 'tr td a.remove', function () {
            if (confirm("Bạn có chắc muốn xoá ?") == true) {
                for (var i = arr_markers.length - 1; i >= 0; --i) {
                    if (arr_markers[i].id == $(this).attr('data-id')) {
                        arr_markers.splice(i, 1);
                    }
                }
                $('.ekmap_list_marker tbody').empty();
                if (arr_markers.length > 0) {
                    mapMarkers1.forEach((marker) => marker.remove())
                    mapMarkers1 = [];
                    mapMarkers2.forEach((marker) => marker.remove())
                    mapMarkers2 = [];
                    mapMarkers_open1.forEach((marker) => marker.remove())
                    mapMarkers_open1 = [];
                    mapMarkers_open2.forEach((marker) => marker.remove())
                    mapMarkers_open2 = [];
                    for (let i = 0; i < arr_markers.length; i++) {
                        let class_edit, path_img;
                        if (arr_markers[i].check == 1) {
                            class_edit = 'edit_path';
                        } else {
                            class_edit = '';
                        }
                        let svg = '<svg display="block" style="margin: auto;" height="41px" width="27px" viewBox="0 0 27 41"><g fill-rule="nonzero"><g transform="translate(3.0, 29.0)" fill="#000000"><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="10.5" ry="5.25002273"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="10.5" ry="5.25002273"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="9.5" ry="4.77275007"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="8.5" ry="4.29549936"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="7.5" ry="3.81822308"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="6.5" ry="3.34094679"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="5.5" ry="2.86367051"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="4.5" ry="2.38636864"></ellipse></g><g fill="' + arr_markers[i].color + '"><path d="M27,13.5 C27,19.074644 20.250001,27.000002 14.75,34.500002 C14.016665,35.500004 12.983335,35.500004 12.25,34.500002 C6.7499993,27.000002 0,19.222562 0,13.5 C0,6.0441559 6.0441559,0 13.5,0 C20.955844,0 27,6.0441559 27,13.5 Z"></path></g><g opacity="0.25" fill="' + arr_markers[i].color + '"><path d="M13.5,0 C6.0441559,0 0,6.0441559 0,13.5 C0,19.222562 6.7499993,27 12.25,34.5 C13,35.522727 14.016664,35.500004 14.75,34.5 C20.250001,27 27,19.074644 27,13.5 C27,6.0441559 20.955844,0 13.5,0 Z M13.5,1 C20.415404,1 26,6.584596 26,13.5 C26,15.898657 24.495584,19.181431 22.220703,22.738281 C19.945823,26.295132 16.705119,30.142167 13.943359,33.908203 C13.743445,34.180814 13.612715,34.322738 13.5,34.441406 C13.387285,34.322738 13.256555,34.180814 13.056641,33.908203 C10.284481,30.127985 7.4148684,26.314159 5.015625,22.773438 C2.6163816,19.232715 1,15.953538 1,13.5 C1,6.584596 6.584596,1 13.5,1 Z"></path></g><g transform="translate(6.0, 7.0)" fill="#FFFFFF"></g><g transform="translate(8.0, 8.0)"><circle fill="' + arr_markers[i].color + '" opacity="0.25" cx="5.5" cy="5.5" r="5.4999962"></circle><circle fill="#FFFFFF" cx="5.5" cy="5.5" r="5.4999962"></circle></g></g></svg>';
                        $('.ekmap_list_marker tbody').prepend('<tr><td>' + arr_markers[i].title + '</td><td data-color="' + arr_markers[i].color + '">' + svg + '</td><td>' + arr_markers[i].phone + '</td><td>' + arr_markers[i].lon + '</td><td>' + arr_markers[i].lat + '</td><td>' + arr_markers[i].link + '</td><td><div class="action"><a href="#" class="edit ' + class_edit + '" data-id="' + arr_markers[i].id + '" data-img="' + arr_markers[i].image + '" data-width="' + arr_markers[i].width + '" data-height="' + arr_markers[i].height + '" data-content="' + arr_markers[i].content + '" data-phone="' + arr_markers[i].phone + '" data-button="' + arr_markers[i].button_text + '" data-btncolor="' + arr_markers[i].button_color + '" data-btnground="' + arr_markers[i].button_ground + '" data-open="' + arr_markers[i].open + '" data-img="' + arr_markers[i].img + '"><i class="fa fa-pencil" aria-hidden="true"></i></a><a href="#" class="remove_fix" data-id="' + arr_markers[i].id + '"><i class="fa fa-trash" aria-hidden="true"></i></a></div></td></tr>');
                        let html = '';
                        html += '<div class="content_popup_ekmap">';
                        if (arr_markers[i].image != '') {
                            html += '<img src="' + arr_markers[i].image + '" alt="' + arr_markers[i].title + '" width="' + arr_markers[i].width + '" height="' + arr_markers[i].height + '" />';
                        }
                        if (arr_markers[i].title != '') {
                            html += '<h3>' + arr_markers[i].title + '</h3>';
                        }
                        if (arr_markers[i].content != '') {
                            html += '<p>' + arr_markers[i].content + '</p>';
                        }
                        if (arr_markers[i].phone != '') {
                            html += '<p><i class="fa fa-phone" aria-hidden="true"></i>\n ' + arr_markers[i].phone + '</p>';
                        }
                        let style_btn = '';
                        if (arr_markers[i].button_color != '') {
                            style_btn += 'color: ' + arr_markers[i].button_color + ';';
                        }
                        if (arr_markers[i].button_ground != '') {
                            style_btn += 'background-color: ' + arr_markers[i].button_ground + ';';
                        }
                        if (arr_markers[i].button_text != '') {
                            html += '<p style="display:flex; justify-content: center;"><a href="' + arr_markers[i].link + '" style="' + style_btn + '">' + arr_markers[i].button_text + '</a>';
                        }
                        if ($('.ekmap_add_direction').val() != 0) {
                            if (arr_markers[i].button_text == '') html += '<p style="display:flex; justify-content: center;">';
                            html += '<a class="ek_routing" style="' + style_btn + '" data-lon="' + arr_markers[i].lon + '" data-lat="' + arr_markers[i].lat + '">Chỉ đường</a>';
                            html += '</p>';
                        }
                        if ($('.ekmap_add_direction').val() == 0 && arr_markers[i].button_text != '') {
                            html += '</p>';
                        }
                        html += '</div>';
                        const popup = new maplibregl.Popup({ focusAfterOpen: false, closeOnClick: false, offset: 25 }).setHTML(html);
                        if (arr_markers[i].lon != '' && arr_markers[i].lat != '') {
                            marker1 = new maplibregl.Marker({ color: arr_markers[i].color })
                                .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                                .setPopup(popup)
                                .addTo(map);
                            marker2 = new maplibregl.Marker({ color: arr_markers[i].color })
                                .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                                .setPopup(popup)
                                .addTo(map2);
                            if (arr_markers[i].open == 1) {
                                const marker_open1 = new maplibregl.Popup({closeButton:false, focusAfterOpen: false, closeOnClick: false, offset: 25, color: arr_markers[i].color })
                                    .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                                    .setHTML(html)
                                    .addTo(map);

                                const marker_open2 = new maplibregl.Popup({closeButton:false, focusAfterOpen: false, closeOnClick: false, offset: 25, color: arr_markers[i].color })
                                    .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                                    .setHTML(html)
                                    .addTo(map2);
                                mapMarkers_open1.push(marker_open1);
                                mapMarkers_open2.push(marker_open2);
                            }
                            mapMarkers1.push(marker1);
                            mapMarkers2.push(marker2);
                        }
                    }
                    renderMarker(mapMarkers1);
                    renderMarker(mapMarkers2);
                    renderPopup(mapMarkers_open1);
                    renderPopup(mapMarkers_open2);
                } else {
                    $('.ekmap_list_marker tbody').append('<tr><td colspan="7">' + $('.ekmap_add_text_alert_empty').val() + '</td></tr>');
                }

                $('.ekmap_add_list_marker').val(JSON.stringify(arr_markers));
                console.log(arr_markers);
            }
            return false;
        });

        //remove object marker
        $('.ekmap_list.ekmap_edit_fix table tbody').on('click', 'tr td a.remove_fix', function () {
            let id = $(this).attr('data-id');
            let $this = $(this);

            if (confirm("Bạn có chắc muốn xoá ?") == true) {
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: ajax_admin.url_admin,
                    data: {
                        'action': 'removeMarkerAdmin',
                        'id': id
                    },
                    beforeSend: function () {
                        for (var i = arr_markers.length - 1; i >= 0; --i) {
                            if (arr_markers[i].id == $(this).attr('data-id')) {
                                arr_markers.splice(i, 1);
                            }
                        }
                        $this.parent().parent().parent().remove();
                    },
                    success: function (response) {
                        console.log(response.data);
                        if (response.success) {
                            window.location.href = $('.ekmap_link_edit').val();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('The following error occured: ' + textStatus, errorThrown);
                    }
                });

                return false;
            }

            return false;
        });

        //load edit object marker
        $('.ekmap_list table tbody').on('click', 'tr td a.edit', function () {
            $('.btn_add_marker').removeClass('active')
            $('.btn_edit_marker').addClass('active')
            $('.btn_edit_marker').attr('data-id', $(this).attr('data-id'));
            $('.ekmap_add_title_marker').val($(this).parent().parent().siblings('td:nth-child(1)').text());

            $('#ekmap_add_content').val('');
            tinymce.activeEditor.setContent("");
            //add content marker
            var cursorPos = $('#ekmap_add_content').prop('selectionStart');
            var v = $('#ekmap_add_content').val();
            var textBefore = v.substring(0, cursorPos);
            var textAfter = v.substring(cursorPos, v.length);
            function addTextIntoEditor(myText) {
                tinymce.activeEditor.execCommand('mceInsertContent', false, myText);
            }
            addTextIntoEditor($(this).attr('data-content'));

            if ($(this).hasClass('edit_path')) {
                $('.btn_edit_marker').addClass('btn_edit_marker_edit');
            }

            $('.ekmap_add_color_marker').val($(this).parent().parent().siblings('td:nth-child(2)').attr('data-color'));
            // $(document).find('.ekmap_add .icon_group .ekmap_img_icon').empty();

            // $('.ekmap_add_icon').val($(this).attr('data-img'));
            // $('.ekmap_add .icon_group .ekmap_img_icon').html('<img src="' + $(this).attr('data-img') + '" alt="logo" />');
            
            if($(this).attr('data-img')!='') {
                $('.ekmap_img_icon').attr('src',$(this).attr('data-img'));
                $('.ekmap_add .icon_group .remove_icon').show();
            } 
            $('.ekmap_add_open_marker').val($(this).attr('data-open'));
            $('.ekmap_add_width_marker').val($(this).attr('data-width'));
            $('.ekmap_add_height_marker').val($(this).attr('data-height'));
            $('.ekmap_add_number_marker').val($(this).attr('data-phone'));
            $('.ekmap_add_title_btn_marker').val($(this).attr('data-button'));
            $('.ekmap_add_title_btn_color_marker').val($(this).attr('data-btncolor'));
            $('.ekmap_add_title_btn_backgroud_marker').val($(this).attr('data-btnground'));
            $('.ekmap_add_lon_marker').val($(this).parent().parent().siblings('td:nth-child(4)').text());
            $('.ekmap_add_lat_marker').val($(this).parent().parent().siblings('td:nth-child(5)').text());
            $('.ekmap_add_link_marker').val($(this).parent().parent().siblings('td:nth-child(6)').text());
            $('.ekmap_add_list_marker').val(JSON.stringify(arr_markers));
            return false;
        });

        //save edit object marker
        $('.btn_edit_marker').on('click', function () {
            if ($('.ekmap_add_title_marker').val() == '') {
                alert("Tiêu đề không được để trống!");
                return false;
            }
            let content_;
            let editor = tinyMCE.get('ekmap_add_content');
            if (editor) {
                // Ok, the active tab is Visual
                content_ = editor.getContent();
            } else {
                // The active tab is HTML, so just query the textarea
                content_ = $('#ekmap_add_content').val();
            }
            if (content_.length>50){
                alert("Mô tả tối đa 40 ký tự!");
                return false;
            }
            if($('.ekmap_add_lat_marker').val()=="" || $('.ekmap_add_lon_marker').val()=="" ){
                alert("Giá trị tọa độ không được để trống!");
                return false;
            }
            if($('.ekmap_img_icon').attr('src')!=""){
                if($('.ekmap_add_width_marker').val()=="" || $('.ekmap_add_height_marker').val()=="" ){
                    alert("Độ rộng, Độ cao bản đồ không được để trống!");
                    return false;
                }
                var ArrUnits=['em', 'ex','%', 'px', 'cm', 'mm', 'in', 'pt', 'pc','ch','rem','vh', 'vw','vmin','vmax'];
                var widthVal = $('.ekmap_add_width_marker').val();
                var Wlength = widthVal.split("").length;
                if (widthVal.substr(Wlength-1) =='%') checkVal(widthVal.substr(0,Wlength-1));
                else if (widthVal.substr(Wlength-2) =='px') checkVal(widthVal.substr(0,Wlength-2));
                else if (widthVal.substr(Wlength-2) =='vh') checkVal(widthVal.substr(0,Wlength-2));
                else if (widthVal.substr(Wlength-2) =='vw') checkVal(widthVal.substr(0,Wlength-2));
                else if (widthVal.substr(Wlength-2) =='em') checkVal(widthVal.substr(0,Wlength-2));
                else if (widthVal.substr(Wlength-3) =='rem') checkVal(widthVal.substr(0,Wlength-3));
                else {
                    alert("Giá trị Độ rộng, Độ cao không hợp lệ!");
                    return false;
                }
                var heightVal = $('.ekmap_add_height_marker').val();
                var Hlength = heightVal.split("").length;
                if (heightVal.substr(Hlength-1) =='%') checkVal(heightVal.substr(0,Hlength-1));
                else if (heightVal.substr(Hlength-2) =='px') checkVal(heightVal.substr(0,Hlength-2));
                else if (heightVal.substr(Hlength-2) =='vh') checkVal(heightVal.substr(0,Hlength-2));
                else if (heightVal.substr(Hlength-2) =='vw') checkVal(heightVal.substr(0,Hlength-2));
                else if (heightVal.substr(Hlength-2) =='em') checkVal(heightVal.substr(0,Hlength-2));
                else if (heightVal.substr(Hlength-3) =='rem') checkVal(heightVal.substr(0,Hlength-3));
                else {
                    alert("Giá trị Độ rộng, Độ cao không hợp lệ!");
                    return false;
                }
                function checkVal(val){
                    if (isNaN(val)){
                        alert("Giá trị Độ rộng, Độ cao không hợp lệ!");
                        return false;
                    }
                }
            }
            if($('.ekmap_add_number_marker').val()=="" ){
                alert("Số điện thoại không được để trống!");
                return false;
            }
            if($('.ekmap_add_link_marker').val()!="" &&$('.ekmap_add_title_btn_marker').val()==""){
                alert("Tiêu đề nút không được để trống!");
                return false;
            }
            if($('.ekmap_add_link_marker').val()=="" &&$('.ekmap_add_title_btn_marker').val()!=""){
                alert("Liên kết không được để trống!");
                return false;
            }
            $('.maplibregl-popup').remove();
            for (var i = arr_markers.length - 1; i >= 0; --i) {
                if (arr_markers[i].id == $(this).attr('data-id')) {
                    arr_markers[i].title = $('.ekmap_add_title_marker').val();
                    arr_markers[i].content = content_;
                    // if ($('.ekmap_path_img').val() != '') {
                    //     arr_markers[i].image = $('.ekmap_add_icon').val();
                    // }
                    arr_markers[i].image = $('.ekmap_img_icon').attr('src');
                    arr_markers[i].width = $('.ekmap_add_width_marker').val();
                    arr_markers[i].height = $('.ekmap_add_height_marker').val();
                    arr_markers[i].color = $('.ekmap_add_color_marker').val();
                    arr_markers[i].phone = $('.ekmap_add_number_marker').val();
                    arr_markers[i].lon = $('.ekmap_add_lon_marker').val();
                    arr_markers[i].lat = $('.ekmap_add_lat_marker').val();
                    arr_markers[i].link = $('.ekmap_add_link_marker').val();
                    arr_markers[i].button_text = $('.ekmap_add_title_btn_marker').val();
                    arr_markers[i].button_color = $('.ekmap_add_title_btn_color_marker').val();
                    arr_markers[i].button_ground = $('.ekmap_add_title_btn_backgroud_marker').val();
                    arr_markers[i].check = 0;
                    arr_markers[i].open = $('.ekmap_add_open_marker').val();
                }
            }

            $('.ekmap_list_marker tbody').empty();
            mapMarkers1.forEach((marker) => marker.remove())
            mapMarkers1 = [];
            mapMarkers2.forEach((marker) => marker.remove())
            mapMarkers2 = [];
            mapMarkers_open1.forEach((marker) => marker.remove())
            mapMarkers_open1 = [];
            mapMarkers_open2.forEach((marker) => marker.remove())
            mapMarkers_open2 = [];
            for (let i = 0; i < arr_markers.length; i++) {
                let class_edit, path_img;
                if ($(this).hasClass('btn_edit_marker_edit')) {
                    class_edit = 'edit_path';
                } else {
                    if (arr_markers[i].check == 1) {
                        class_edit = 'edit_path';
                    } else {
                        class_edit = '';
                    }
                }
                let svg = '<svg display="block" style="margin: auto;" height="41px" width="27px" viewBox="0 0 27 41"><g fill-rule="nonzero"><g transform="translate(3.0, 29.0)" fill="#000000"><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="10.5" ry="5.25002273"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="10.5" ry="5.25002273"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="9.5" ry="4.77275007"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="8.5" ry="4.29549936"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="7.5" ry="3.81822308"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="6.5" ry="3.34094679"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="5.5" ry="2.86367051"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="4.5" ry="2.38636864"></ellipse></g><g fill="' + arr_markers[i].color + '"><path d="M27,13.5 C27,19.074644 20.250001,27.000002 14.75,34.500002 C14.016665,35.500004 12.983335,35.500004 12.25,34.500002 C6.7499993,27.000002 0,19.222562 0,13.5 C0,6.0441559 6.0441559,0 13.5,0 C20.955844,0 27,6.0441559 27,13.5 Z"></path></g><g opacity="0.25" fill="' + arr_markers[i].color + '"><path d="M13.5,0 C6.0441559,0 0,6.0441559 0,13.5 C0,19.222562 6.7499993,27 12.25,34.5 C13,35.522727 14.016664,35.500004 14.75,34.5 C20.250001,27 27,19.074644 27,13.5 C27,6.0441559 20.955844,0 13.5,0 Z M13.5,1 C20.415404,1 26,6.584596 26,13.5 C26,15.898657 24.495584,19.181431 22.220703,22.738281 C19.945823,26.295132 16.705119,30.142167 13.943359,33.908203 C13.743445,34.180814 13.612715,34.322738 13.5,34.441406 C13.387285,34.322738 13.256555,34.180814 13.056641,33.908203 C10.284481,30.127985 7.4148684,26.314159 5.015625,22.773438 C2.6163816,19.232715 1,15.953538 1,13.5 C1,6.584596 6.584596,1 13.5,1 Z"></path></g><g transform="translate(6.0, 7.0)" fill="#FFFFFF"></g><g transform="translate(8.0, 8.0)"><circle fill="' + arr_markers[i].color + '" opacity="0.25" cx="5.5" cy="5.5" r="5.4999962"></circle><circle fill="#FFFFFF" cx="5.5" cy="5.5" r="5.4999962"></circle></g></g></svg>';
                $('.ekmap_list_marker tbody').prepend('<tr><td>' + arr_markers[i].title + '</td><td data-color="' + arr_markers[i].color + '">' + svg + '</td><td>' + arr_markers[i].phone + '</td><td>' + arr_markers[i].lon + '</td><td>' + arr_markers[i].lat + '</td><td>' + arr_markers[i].link + '</td><td><div class="action"><a href="#" class="edit ' + class_edit + '" data-id="' + arr_markers[i].id + '" data-img="' + arr_markers[i].image + '" data-width="' + arr_markers[i].width + '" data-height="' + arr_markers[i].height + '" data-content="' + arr_markers[i].content + '" data-phone="' + arr_markers[i].phone + '" data-button="' + arr_markers[i].button_text + '" data-btncolor="' + arr_markers[i].button_color + '" data-btnground="' + arr_markers[i].button_ground + '" data-open="' + arr_markers[i].open + '" data-img="' + arr_markers[i].img + '"><i class="fa fa-pencil" aria-hidden="true"></i></a><a href="#" class="remove_fix" data-id="' + arr_markers[i].id + '"><i class="fa fa-trash" aria-hidden="true"></i></a></div></td></tr>');
                let html = '';
                html += '<div class="content_popup_ekmap">';
                if (arr_markers[i].image != '') {
                    html += '<img src="' + arr_markers[i].image + '" alt="' + arr_markers[i].title + '" width="' + arr_markers[i].width + '" height="' + arr_markers[i].height + '" />';
                }
                if (arr_markers[i].title != '') {
                    html += '<h3>' + arr_markers[i].title + '</h3>';
                }
                if (arr_markers[i].content != '') {
                    html += '<p>' + arr_markers[i].content + '</p>';
                }
                if (arr_markers[i].phone != '') {
                    html += '<p><i class="fa fa-phone" aria-hidden="true"></i>\n ' + arr_markers[i].phone + '</p>';
                }
                let style_btn = '';
                if (arr_markers[i].button_color != '') {
                    style_btn += 'color: ' + arr_markers[i].button_color + ';';
                }
                if (arr_markers[i].button_ground != '') {
                    style_btn += 'background-color: ' + arr_markers[i].button_ground + ';';
                }
                if (arr_markers[i].button_text != '') {
                    html += '<p style="display:flex; justify-content: center;"><a href="' + arr_markers[i].link + '" style="' + style_btn + '">' + arr_markers[i].button_text + '</a>';
                }
                if ($('.ekmap_add_direction').val() != 0) {
                    if (arr_markers[i].button_text == '') html += '<p style="display:flex; justify-content: center;">';
                    html += '<a class="ek_routing" style="' + style_btn + '" data-lon="' + arr_markers[i].lon + '" data-lat="' + arr_markers[i].lat + '">Chỉ đường</a>';
                    html += '</p>';
                }
                if ($('.ekmap_add_direction').val() == 0 && arr_markers[i].button_text != '') {
                    html += '</p>';
                }
                html += '</div>';
                try {
                    const popup = new maplibregl.Popup({ focusAfterOpen: false, closeOnClick: false, offset: 25 }).setHTML(html);
                    if (arr_markers[i].lon != '' && arr_markers[i].lat != '') {
                        marker1 = new maplibregl.Marker({ color: arr_markers[i].color })
                            .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                            .setPopup(popup)
                            .addTo(map);
                        marker2 = new maplibregl.Marker({ color: arr_markers[i].color })
                            .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                            .setPopup(popup)
                            .addTo(map2);
                        if (arr_markers[i].open == 1) {
                            const marker_open1 = new maplibregl.Popup({ closeButton:false, focusAfterOpen: false, closeOnClick: false, offset: 25, color: arr_markers[i].color })
                                .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                                .setHTML(html)
                                .addTo(map);

                            const marker_open2 = new maplibregl.Popup({ closeButton:false, focusAfterOpen: false, closeOnClick: false, offset: 25, color: arr_markers[i].color })
                                .setLngLat([arr_markers[i].lon, arr_markers[i].lat])
                                .setHTML(html)
                                .addTo(map2);
                            mapMarkers_open1.push(marker_open1);
                            mapMarkers_open2.push(marker_open2);
                        }
                        mapMarkers1.push(marker1);
                        mapMarkers2.push(marker2);
                    }
                } catch (e) {

                }
            }
            renderMarker(mapMarkers1);
            renderMarker(mapMarkers2);
            renderPopup(mapMarkers_open1);
            renderPopup(mapMarkers_open2);
            $('.ekmap_add_list_marker').val(JSON.stringify(arr_markers));
            console.log(arr_markers);
            resetInput();
            $('.btn_add_marker').addClass('active');
            $(this).removeClass('active');
            $('.btn_edit_marker').removeClass('btn_edit_marker_edit');

            return false;
        });

        //xu ly hinh anh
        $(document).on('click', '.ekmap_add .icon_group .up_icon', function () {
            $(document).find('.ekmap_add .icon_group .ekmap_add_icon').click();  
            $(document).on('change','.ekmap_add_icon',function(e){
                var imgFile = e.target.files[0]
                var maxSize ='100000'; // bytes
                var fileSize = imgFile.size;
                var base64Image;
                if (fileSize < maxSize) {
                    var fileReader = new FileReader();
                    fileReader.readAsDataURL(imgFile);
                    fileReader.onload = function () {
                        base64Image = fileReader.result;
                        $('.ekmap_img_icon').attr('src', base64Image);
                        $('.ekmap_add .icon_group .remove_icon').show();
                        $('.ekmap_add_width_marker').val('100px');
                        $('.ekmap_add_height_marker').val('100%');
                    }
                } else alert('Kích thước tệp lớn hơn 100KB');
            });
        });

        $(document).on('click', '.ekmap_add .icon_group .remove_icon', function () {
            $(document).find('.ekmap_add .icon_group .ekmap_add_icon').empty();
            $('.ekmap_img_icon').removeAttr("src");
            $('.ekmap_img_icon').attr('src', '');
            $('.ekmap_add_width_marker').val('');
            $('.ekmap_add_height_marker').val('');
            $('.ekmap_add .icon_group .remove_icon').hide();
        });

        //save map
        $(document).on('click','.add_map_sub', function () {
            if ($('.ekmap_add_title').val() == '') {
                alert("Tiêu đề không được để trống!");
                return false;
            }
            if($('.ekmap_add_lat').val()=="" || $('.ekmap_add_lon').val()=="" ){
                alert("Giá trị tọa độ không được để trống!");
                return false;
            }
            if($('.ekmap_add_width').val()=="" || $('.ekmap_add_height').val()=="" ){
                alert("Độ rộng, Độ cao bản đồ không được để trống!");
                return false;
            }
            var ArrUnits=['em', 'ex','%', 'px', 'cm', 'mm', 'in', 'pt', 'pc','ch','rem','vh', 'vw','vmin','vmax'];
            var widthVal = $('.ekmap_add_width').val();
            var Wlength = widthVal.split("").length;
            if (widthVal.substr(Wlength-1) =='%') checkVal(widthVal.substr(0,Wlength-1));
            else if (widthVal.substr(Wlength-2) =='px') checkVal(widthVal.substr(0,Wlength-2));
            else if (widthVal.substr(Wlength-2) =='vh') checkVal(widthVal.substr(0,Wlength-2));
            else if (widthVal.substr(Wlength-2) =='vw') checkVal(widthVal.substr(0,Wlength-2));
            else if (widthVal.substr(Wlength-2) =='em') checkVal(widthVal.substr(0,Wlength-2));
            else if (widthVal.substr(Wlength-3) =='rem') checkVal(widthVal.substr(0,Wlength-3));
            else {
                alert("Giá trị Độ rộng, Độ cao không hợp lệ!");
                return false;
            }
            var heightVal = $('.ekmap_add_height').val();
            var Hlength = heightVal.split("").length;
            if (heightVal.substr(Hlength-1) =='%') checkVal(heightVal.substr(0,Hlength-1));
            else if (heightVal.substr(Hlength-2) =='px') checkVal(heightVal.substr(0,Hlength-2));
            else if (heightVal.substr(Hlength-2) =='vh') checkVal(heightVal.substr(0,Hlength-2));
            else if (heightVal.substr(Hlength-2) =='vw') checkVal(heightVal.substr(0,Hlength-2));
            else if (heightVal.substr(Hlength-2) =='em') checkVal(heightVal.substr(0,Hlength-2));
            else if (heightVal.substr(Hlength-3) =='rem') checkVal(heightVal.substr(0,Hlength-3));
            else {
                alert("Giá trị Độ rộng, Độ cao không hợp lệ!");
                return false;
            }
            function checkVal(val){
                if (isNaN(val)){
                    alert("Giá trị Độ rộng, Độ cao không hợp lệ!");
                    return false;
                }
            }
        });

        //direction
        if(api_key){
            var geocoding = new ekmapplf.service.Geocoding(api_key);
            var routingService = new ekmapplf.service.Routing({ apiKey: api_key, profile: $('.ek_vehicle').val() });
        }         
        function renderMarker(arrMarker){
            arrMarker.forEach((marker) => {
                var popup = marker.getPopup();
                if ($('.ekmap_add_direction').val() != 0) {
                    popup._content.querySelector('.ek_routing').addEventListener('click', () => {
                        var lon = popup._lngLat.lng;
                        var lat = popup._lngLat.lat;
                        if ($('.ekmap_add_direction').val() == 1) {
                            RoutingtoCurrentPosition(lon, lat);
                            popup.remove();
                        }
                        if ($('.ekmap_add_direction').val() == 2) {
                            RoutingbyGG(lon, lat);
                        }
                    })
                }
            });
        }

        function renderPopup(arrPopup){
            arrPopup.forEach((popup) => {
                if ($('.ekmap_add_direction').val() != 0) {
                    popup.getElement().querySelector('.ek_routing').addEventListener('click', () => {
                        var lon = popup._lngLat.lng;
                        var lat = popup._lngLat.lat;
                        if ($('.ekmap_add_direction').val() == 1) {
                            RoutingtoCurrentPosition(lon, lat);
                        }
                        if ($('.ekmap_add_direction').val() == 2) {
                            RoutingbyGG(lon, lat);
                        }
                    })
                }
            });
        }

        $(document).on('click', '.ek-geolocate', function () {
            if (currentPosition.length == 0 || currentPosition2.length == 0) {
                geolocate.trigger();
                geolocate2.trigger();
            }
            var paramRever = {
                'point.lon': currentPosition[0],
                'point.lat': currentPosition[1]
            }
            geocoding.reverse(paramRever, function (error, response) {
                if (response.status == 'OK'){
                    if (response.results[0].name) $('.ek-dr-from')[0].value = response.results[0].name;
                    else $('.ek-dr-from')[0].value = response.results[0].formatted_address;
                }
            })
            var paramRever2 = {
                'point.lon': currentPosition2[0],
                'point.lat': currentPosition2[1]
            }
            geocoding.reverse(paramRever2, function (error, response) {
                if (response.status == 'OK'){
                    if (response.results[0].name) $('.ek-dr-from')[1].value = response.results[0].name;
                    else $('.ek-dr-from')[1].value = response.results[0].formatted_address;
                }
            })
            setTimeout(changeinput, 300);
        });

        $(document).on('click', '.ek-geolocate2', function () {
            if (currentPosition.length == 0 || currentPosition2.length == 0) {
                geolocate.trigger();
                geolocate2.trigger();
            }
            var paramRever = {
                'point.lon': currentPosition[0],
                'point.lat': currentPosition[1]
            }
            geocoding.reverse(paramRever, function (error, response) {
                if (response.status == 'OK'){
                    if (response.results[0].name) $('.ek-dr-to')[0].value = response.results[0].name;
                    else $('.ek-dr-to')[0].value = response.results[0].formatted_address;
                }
            })
            var paramRever2 = {
                'point.lon': currentPosition2[0],
                'point.lat': currentPosition2[1]
            }
            geocoding.reverse(paramRever2, function (error, response) {
                if (response.status == 'OK'){
                    if (response.results[0].name) $('.ek-dr-to')[1].value = response.results[0].name;
                    else $('.ek-dr-to')[1].value = response.results[0].formatted_address;
                }
            })
            setTimeout(changeinput, 300);
        });

        $('.ek-vehicle').on('change', function () {
            changeinput();
        });

        $('.ek-swap').on('click', function () {
            console.log('click')
            var text1= $('.ek-dr-from').val();
            var text2= $('.ek-dr-to').val();
            $('.ek-dr-from').val(text2);
            $('.ek-dr-to').val(text1);
            changeinput();
        });

        $(document).on('click', '.ek-dr-close', function () {
            collapseSidebar('left');
            collapseSidebar('left2');
            if (markerFrom) markerFrom.remove();
            if (markerFrom2) markerFrom2.remove();
            if (markerTo) markerTo.remove();
            if (markerTo2) markerTo2.remove();
            if (popupDr) popupDr.remove();
            if (popupDr2) popupDr2.remove();
            if (map.getLayer('route')) map.removeLayer('route');
            if (map.getSource('route')) map.removeSource('route');
            if (map2.getLayer('route')) map2.removeLayer('route');
            if (map2.getSource('route')) map2.removeSource('route');
            $('.ek-dr-from').val('');
            $('.ek-dr-to').val('');
            $('.ek-vehicle').val('car');
        });

        function RoutingbyGG(lon, lat) {
            window.open("https://www.google.com/maps/dir//" + lat + "," + lon , "_blank");
        }

        function RoutingtoCurrentPosition(lon, lat) {
            var startP, endP;
            endP = [lon, lat].toString();
            var param = {
                'point.lon': lon,
                'point.lat': lat,
            };
            geocoding.reverse(param, function (error, response) {
                if (response.status == 'OK'){
                    $('.ek-dr-to').val(response.results[0].name);
                    if (response.results[0].name) $('.ek-dr-to').val(response.results[0].name);
                    else $('.ek-dr-to').val(response.results[0].formatted_address);
                }
            });
            if ($('.ek-dr-from').val() != '') {
                var startAdrs = $('.ek-dr-from').val();
                geocoding.geocoding(startAdrs, function (error, response) {
                    var result = response.results[0].geometry.location;
                    startP = [result.lng, result.lat].toString();
                    routing(startP, endP);
                });
            } else if (currentPosition.length == 0 || currentPosition2.length == 0) {
                    geolocate.trigger();
                    geolocate.on('geolocate', function () {
                        if (count1 == 0) {
                            var paramRever = {
                                'point.lon': currentPosition[0],
                                'point.lat': currentPosition[1]
                            }
                            geocoding.reverse(paramRever, function (error, response) {
                                if (response.status == 'OK'){
                                    if (response.results[0].name) $('.ek-dr-from')[0].value = response.results[0].name;
                                    else $('.ek-dr-from')[0].value = response.results[0].formatted_address;
                                    startP = currentPosition.toString();
                                    routing(startP, endP);
                                }
                            });
                            count1++;
                        }
                    })
                    geolocate2.trigger();
                    geolocate2.on('geolocate', function () {
                        if (count2 == 0) {
                            var paramRever = {
                                'point.lon': currentPosition2[0],
                                'point.lat': currentPosition2[1]
                            }
                            geocoding.reverse(paramRever, function (error, response) {
                                if (response.results[0].name) $('.ek-dr-from')[1].value = response.results[0].name;
                                else $('.ek-dr-from')[1].value = response.results[0].formatted_address;
                                startP = currentPosition2.toString();
                                routing(startP, endP);
                            });
                            count2++;
                        }
                    })
            } else if (currentPosition.length != 0 || currentPosition2.length != 0){
                var paramRever = {
                    'point.lon': currentPosition[0],
                    'point.lat': currentPosition[1]
                }
                geocoding.reverse(paramRever, function (error, response) {
                    if (response.status == 'OK'){
                        if (response.results[0].name) $('.ek-dr-from')[0].value = response.results[0].name;
                        else $('.ek-dr-from')[0].value = response.results[0].formatted_address;
                    }
                })
                var paramRever2 = {
                    'point.lon': currentPosition2[0],
                    'point.lat': currentPosition2[1]
                }
                geocoding.reverse(paramRever2, function (error, response) {
                    if (response.status == 'OK'){
                        if (response.results[0].name) $('.ek-dr-from')[1].value = response.results[0].name;
                        else $('.ek-dr-from')[1].value = response.results[0].formatted_address;
                    }
                })
                startP = currentPosition.toString();
                setTimeout(routing(startP, endP), 300)
            }
        };

        function changeinput() {
            var startPnt = [], endPnt = [];
            var classList = document.getElementById('ek_tab1').className.split(/\s+/);
            if (classList == 'active') {
                var startAdrs = $('.ek-dr-from')[0].value;
                var endAdrs = $('.ek-dr-to')[0].value;
            } else {
                var startAdrs = $('.ek-dr-from')[1].value;
                var endAdrs = $('.ek-dr-to')[1].value;
            }
            if (startAdrs != "" && endAdrs != "") {
                geocoding.geocoding(startAdrs, function (error, response) {
                    startPnt = response.results[0].geometry.location;
                });
                geocoding.geocoding(endAdrs, function (error, response) {
                    endPnt = response.results[0].geometry.location;
                });
                setTimeout(function () {
                    startPnt = [startPnt.lng, startPnt.lat].toString();
                    endPnt = [endPnt.lng, endPnt.lat].toString();
                    routing(startPnt, endPnt);
                }, 500)
            }
        };

        function routing(startPoint, endPoint) {
            if (startPoint != "," && endPoint != "," && startPoint != "" && endPoint != "" && startPoint != endPoint) {
                var profile = $('.ek-vehicle').val();
                routingService.setProfile(profile);
                var coordinates = startPoint + ";" + endPoint;
                routingService.setCoordinates(coordinates);
                var paramRoute = {
                    overview: "full",
                    alternatives: false,
                    steps: true,
                    geometries: "geojson",
                };
                var classList = document.getElementById('ek_tab1').className.split(/\s+/);
                if (classList == 'active') {
                    mapMarkers_open1.forEach((marker) => marker.remove())
                    mapMarkers_open1 = [];
                    routingService.getRoute(paramRoute, function (error, data) {
                        isCollapse = true;
                        if (data.code == 'Ok') {
                            let bbox = [startPoint.split(","), endPoint.split(",")];
                            map.fitBounds(bbox, {
                                padding: { left: 480, right: 150, top: 50, bottom:50 },
                            });
                            var featureData = {
                                'type': 'Feature',
                                'properties': {},
                                'geometry': data.routes[0].geometry
                            };
                            if (map.getSource('route')) {
                                map.getSource('route').setData(featureData);
                            } else {
                                map.addSource('route', {
                                    'type': 'geojson',
                                    'data': featureData
                                });
                                map.addLayer({
                                    'id': 'route',
                                    'type': 'line',
                                    'source': 'route',
                                    'paint': {
                                        'line-color': '#4882c5',
                                        'line-width': 7,
                                        'line-opacity': 0.9
                                    }
                                });
                            }
                            var direction = data.routes[0];
                            let html = '<div class="direct_popup_ekmap">';
                            html += '<span style="width:100%; display:flex;"><span class="ek-dr-icon"><span class="ek-icon-marker"></span></span>' + $('.ek-dr-from').val() + '</span>';
                            html += '<span style="width:100%; display:flex; margin-top: 5px;"><span class="ek-dr-icon"><span class="ek-icon-marker-home"></span></span>' + $('.ek-dr-to').val() + '</span>';
                            html += '<span style="width:100%; display:flex; margin-top: 5px;"><span class="ek-dr-icon"><span class="ek-icon-distance"></span></span>' + format.duration(direction.duration) + '</span>';
                            if (profile == 'car') html += '<span style="width:100%; display:flex; margin-top: 5px;"><span class="ek-dr-icon"><span class="ek-icon-car"></span></span>' + format['metric'](direction.distance) + '</span>';
                            if (profile == 'bicycle') html += '<span style="width:100%; display:flex; margin-top: 5px;"><span class="ek-dr-icon"><span class="ek-icon-bike"></span></span>' + format['metric'](direction.distance) + '</span>';
                            if (profile == 'foot') html += '<span style="width:100%; display:flex; margin-top: 5px;"><span class="ek-dr-icon"><span class="ek-icon-foot"></span></span>' + format['metric'](direction.distance) + '</span>';
                            html += '</div>';
                            popupDr = new maplibregl.Popup({ focusAfterOpen: false, closeOnClick: false, offset: 25 }).setMaxWidth("350px").setHTML(html);
                            if (markerFrom) markerFrom.remove();
                            markerFrom = new maplibregl.Marker()
                                .setLngLat(startPoint.split(","))
                                .addTo(map);

                            if (markerTo) markerTo.remove();
                            markerTo = new maplibregl.Marker({ color: 'red' })
                                .setLngLat(endPoint.split(","))
                                .setPopup(popupDr)
                                .addTo(map);
                            popupDr.setLngLat(endPoint.split(",")).addTo(map);
                            expandSidebar('left');
                            showDirect('left', direction);
                        }
                        else alert('Thông tin đường đi không khả dụng.')
                    })
                } else {
                    mapMarkers_open2.forEach((marker) => marker.remove())
                    mapMarkers_open2 = [];
                    routingService.getRoute(paramRoute, function (error, data) {
                        isCollapse = true;
                        if (data.code == 'Ok') {
                            let bbox = [startPoint.split(","), endPoint.split(",")];
                            map2.fitBounds(bbox, {
                                padding: { left: 480, right: 150, top: 50, bottom:50 },
                            });
                            var featureData = {
                                'type': 'Feature',
                                'properties': {},
                                'geometry': data.routes[0].geometry
                            };
                            if (map2.getSource('route')) {
                                map2.getSource('route').setData(featureData);
                            } else {
                                map2.addSource('route', {
                                    'type': 'geojson',
                                    'data': featureData
                                });
                                map2.addLayer({
                                    'id': 'route',
                                    'type': 'line',
                                    'source': 'route',
                                    'paint': {
                                        'line-color': '#4882c5',
                                        'line-width': 7,
                                        'line-opacity': 0.9
                                    }
                                });
                            }

                            var direction = data.routes[0];
                            let html = '<div class="direct_popup_ekmap" style=" font-size: 12.5px; min-width: 300px; padding: 0px 5px; ">';
                            html += '<span style="width:100%; display:flex;"><span style="width: 20px;height: 20px;padding-right: 5px;"><span class="ek-icon-marker"></span></span>' + $('.ek-dr-from').val() + '</span>';
                            html += '<span style="width:100%; display:flex; margin-top: 5px;"><span style="width: 20px;height: 20px;padding-right: 5px;"><span class="ek-icon-marker-home"></span></span>' + $('.ek-dr-to').val() + '</span>';
                            html += '<span style="width:100%; display:flex; margin-top: 5px;"><span style="width: 20px;height: 20px;padding-right: 5px;"><span class="ek-icon-distance"></span></span>' + format.duration(direction.duration) + '</span>';
                            if (profile == 'car') html += '<span style="width:100%; display:flex; margin-top: 5px;"><span style="width: 20px;height: 20px;padding-right: 5px;"><span class="ek-icon-car"></span></span>' + format['metric'](direction.distance) + '</span>';
                            if (profile == 'bicycle') html += '<span style="width:100%; display:flex; margin-top: 5px;"><span style="width: 20px;height: 20px;padding-right: 5px;"><span class="ek-icon-bike"></span></span>' + format['metric'](direction.distance) + '</span>';
                            if (profile == 'foot') html += '<span style="width:100%; display:flex; margin-top: 5px;"><span style="width: 20px;height: 20px;padding-right: 5px;"><span class="ek-icon-foot"></span></span>' + format['metric'](direction.distance) + '</span>';
                            html += '</div>';
                            popupDr2 = new maplibregl.Popup({ focusAfterOpen: false, closeOnClick: false, offset: 25 }).setMaxWidth("350px").setHTML(html);
                            if (markerFrom2) markerFrom2.remove();
                            markerFrom2 = new maplibregl.Marker()
                                .setLngLat(startPoint.split(","))
                                .addTo(map2);
                            if (markerTo2) markerTo2.remove();
                            markerTo2 = new maplibregl.Marker({ color: 'red' })
                                .setLngLat(endPoint.split(","))
                                .setPopup(popupDr2)
                                .addTo(map2);
                            popupDr2.setLngLat(endPoint.split(",")).addTo(map2);
                            expandSidebar('left2');
                            showDirect('left2', direction);
                        }
                        else alert('Thông tin đường đi không khả dụng.')
                    })
                }
            }
        };

        function showDirect(id, arr) {
            let temp = arr.legs[0].steps;
            // start - unique array object
            let src = [];
            temp.filter(function (item) {
                if (!item.name) return null;
                let i = src.findIndex(x => (x.name == item.name));
                if (i <= -1) {
                    src.push(item);
                }
                return null;
            }); // end - unique array object

            let html = ``;
            html += `
            <div class='ek-dr-h-text'>
                <span>từ <strong>` + $('.ek-dr-from').val() + `</strong></span>
                <span>đến <strong>` + $('.ek-dr-to').val() + `</strong></span>
            </div>
            <span class="ek-dr-cls-btn"><span class="ek-icon-close ek-dr-close"></span></span>`;
            let headerDOM = document.getElementById(id).querySelector(".ek-dr-header");
            headerDOM.innerHTML = html;

            let tempHTML = '';
            src.forEach(x => {
                tempHTML += `
                <div class='ek-step-details'>
                    <span class='ek-step-icon'><span class="${convertArrow(x)}"></span></span>
                    <div class='ek-step-info'>
                        <div> ${convertName(x)}</div>
                        <div>` + format['metric'](x.distance) + `</div>
                    </div>
                </div>`;
            });
            let stepDOM = document.getElementById(id).querySelector(".ek-dr-content");
            stepDOM.innerHTML = tempHTML;

            function convertName(item) {
                let arrow = item.maneuver.modifier;
                let type = item.maneuver.type;
                if (type == 'depart') return `Khởi hành từ ${item.name}`;
                if (arrow == 'left') return `Rẽ trái ${item.name}`;
                if (arrow == 'right') return `Rẽ phải ${item.name}`;
                if (arrow == 'slight right') return `Ngoặt phải ${item.name}`;
                if (arrow == 'slight left') return `Ngoặt trái ${item.name}`;
                if (arrow == 'straight') return `Đi thẳng ${item.name}`;
                if (arrow == 'roundabout') return `Vòng xuyến ${item.name}`;
                return arrow;
            }

            function convertArrow(item) {
                let arrow = item.maneuver.modifier;
                if (!arrow || arrow.includes('straight')) return 'ek-icon-straight';
                if (arrow && arrow.includes('left')) return 'ek-icon-left';
                if (arrow && arrow.includes('right')) return 'ek-icon-right';
            }
        };

        //autocomplete
        function autocomplete(inp) {
            var currentFocus;
            inp.addEventListener("input", function (e) {
                var textSearch = inp.value;
                var list = [];
                var a, b, i, val = this.value;
                var me = this;
                geocoding.autoComplete(textSearch, function (error, response) {
                    if (response.status == 'OK') list = response.results;
                    else list = [];
                    closeAllLists();
                    if (!val) { return false; }
                    currentFocus = -1;
                    a = document.createElement("DIV");
                    a.setAttribute("id", inp.name + "-ek-autocomplete-list");
                    a.setAttribute("class", "ek-autocomplete-items ekmap-scrollbar");
                    a.setAttribute("style", "width:" + inp.offsetWidth + 'px');
                    me.parentNode.appendChild(a);
                    for (i = 0; i < list.length; i++) {
                        b = document.createElement("DIV");
                        b.innerHTML = list[i].name;
                        b.innerHTML += "<input type='hidden' value='" + list[i].formatted_address + "' lon='"+list[i].geometry.location.lng+"' lat='"+list[i].geometry.location.lat+"'>";
                        b.addEventListener("click", function (e) {
                            inp.value = this.getElementsByTagName("input")[0].value;
                            var lon =this.querySelector('input').getAttribute('lon');
                            var lat =this.querySelector('input').getAttribute('lat');
                            inp.setAttribute('data-lon',lon);
                            inp.setAttribute('data-lat',lat);
                            closeAllLists();
                            setTimeout(changeinput, 300);
                        });
                        a.appendChild(b);
                    }
                })
            });
            inp.addEventListener("keydown", function (e) {
                var x = document.getElementById(inp.name + "-ek-autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    currentFocus++;
                    if (currentFocus > 0) document.getElementById(inp.name + "-ek-autocomplete-list").scrollTop += 30;
                    addActive(x);
                } else if (e.keyCode == 38) {
                    currentFocus--;
                    document.getElementById(inp.name + "-ek-autocomplete-list").scrollTop += -30;
                    addActive(x);
                } else if (e.keyCode == 13) {
                    e.preventDefault();
                    if (currentFocus > -1) {
                        if (x) x[currentFocus].click();
                    }
                    setTimeout(changeinput, 300);
                }
            });
            function addActive(x) {
                if (!x) return false;
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                x[currentFocus].classList.add("ek-autocomplete-active");
            }
            function removeActive(x) {
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("ek-autocomplete-active");
                }
            }
            function closeAllLists(elmnt) {
                var x = document.getElementsByClassName("ek-autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            document.addEventListener("click", function (e) {
                closeAllLists(e.target);
            });
        }

        function collapseSidebar(id) {
            var elem = document.getElementById(id);
            elem.classList.add('ek-collapsed')
        }

        function expandSidebar(id) {
            var elem = document.getElementById(id);
            elem.classList.remove("ek-collapsed");
        }
    });

    const format = {
        duration(s) {
            var m = Math.floor(s / 60),
                h = Math.floor(m / 60);
            s %= 60;
            m %= 60;
            if (h === 0 && m === 0) return s + 'giây';
            if (h === 0) return m + 'phút';
            return h + 'giờ ' + m + 'phút';
        },

        metric(m) {
            if (m >= 100000) return (m / 1000).toFixed(0) + 'km';
            if (m >= 10000) return (m / 1000).toFixed(1) + 'km';
            if (m >= 1000) return (m / 1000).toFixed(2) + 'km';
            return m.toFixed(0) + 'm';
        }
    };
}(jQuery));
