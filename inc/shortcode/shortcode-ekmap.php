<?php
add_action('wp_head', function (){});
add_shortcode('vietnam-map', function ($args){
    ob_start();
    if(isset($args['id'])) :
    ?>
    <div id="map_ekmap_<?php echo esc_attr($args['id']); ?>"></div>
    <?php
    $id_map = esc_attr($args['id']);

    add_action( 'wp_footer', function() use( $id_map ){
        $query_ekmap = new WP_Query(array(
            'post_type' => 'vietnam-map',
            'posts_per_page' => 1,
            'p' => sanitize_text_field($id_map),
        ));
        if($query_ekmap->have_posts()) : while ($query_ekmap->have_posts()) : $query_ekmap->the_post();
            $lon_ = get_post_meta( get_the_ID(), 'ekmap_lon', true );
            $lat_ = get_post_meta( get_the_ID(), 'ekmap_lat', true );
            $width_ = get_post_meta( get_the_ID(), 'ekmap_width', true );
            $height_ = get_post_meta( get_the_ID(), 'ekmap_heigth', true );
            $zoom_ = get_post_meta( get_the_ID(), 'ekmap_zoom', true );
            $type_ = get_post_meta( get_the_ID(), 'ekmap_type', true );
            $theme_ = get_post_meta( get_the_ID(), 'ekmap_theme', true );
            $class_ = get_post_meta( get_the_ID(), 'ekmap_custom_class', true );
            $direction_ = get_post_meta( get_the_ID(), 'ekmap_direction', true );
            $bearing_ = get_post_meta( get_the_ID(), 'ekmap_bearing', true );
            $pitch_ = get_post_meta( get_the_ID(), 'ekmap_pitch', true );
        endwhile;
        endif;
        wp_reset_query();
        ?>
        <style>
            #map_ekmap_<?php echo esc_attr($id_map); ?> .maplibregl-popup {
                top: -15px !important
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .maplibregl-popup-close-button {
                position: absolute;
                right: 5px;
                top: 0;
                color: #000;
                border: 0;
                font-size: 20px;
                border-radius: 0 3px 0 0;
                cursor: pointer;
                padding: 0;
                box-shadow: none !important;
                background: #fff !important;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-bike,
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-car,
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-distance,
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-foot,
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-geolocation,
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-marker,
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-marker-home {
                height: 100%;
                width: 100%;
                background-position: 50%;
                background-repeat: no-repeat
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .content_popup_ekmap {
                text-align: center;
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                font-style: normal;
                word-break: break-word;
                color: #2d356b;
                min-width: 120px;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-sidebar,
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ekdrt_ul li {
                font-family: Verdana, Geneva, Tahoma, sans-serif !important
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .content_popup_ekmap h3 {
                margin: 0 0 .5rem !important;
                color: #2d356b !important;
                font-size: 18px;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .content_popup_ekmap p {
                margin: 0 0 .5rem;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .content_popup_ekmap::-webkit-scrollbar {
                width: 5px;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .content_popup_ekmap::-webkit-scrollbar-track {
                background: #f1f1f1;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .content_popup_ekmap::-webkit-scrollbar-thumb {
                background: #0db39e;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .content_popup_ekmap::-webkit-scrollbar-thumb:hover {
                background: #0db39e;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .content_popup_ekmap a {
                padding: 5px 10px;
                text-decoration: none;
                display: inline-block;
                border-radius: 5px;
                outline: 0;
                box-shadow: none;
                margin: 0 5px;
                cursor: pointer;
                min-width: 85px
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .content_popup_ekmap a:hover{
                box-shadow: rgb(0 0 0 / 24%) 0px 3px 8px;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .content_popup_ekmap img {
                margin: auto;
                margin-bottom: 0.5rem;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ekmap-scrollbar::-webkit-scrollbar-track {
                -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
                border-radius: 20px;
                background-color: #fff;
                margin-left: 100px;
                margin-right: 100px;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ekmap-scrollbar::-webkit-scrollbar {
                width: 8px;
                height: 100%;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ekmap-scrollbar::-webkit-scrollbar-thumb {
                border-radius: 5px;
                background-color: #c9c9c9;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-autocomplete-items {
                position: absolute;
                border: 1px solid #d4d4d4;
                border-bottom: none;
                border-top: none;
                z-index: 99;
                margin-top: 35px;
                max-height: 70px;
                overflow: auto
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-autocomplete-items div {
                padding: 7px;
                cursor: pointer;
                background-color: #fff;
                border-bottom: 1px solid #d4d4d4;
                font-size: 13px;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-autocomplete-items div:hover {
                background-color: #e9e9e9;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-autocomplete-active {
                background-color: #f0f8ff !important;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-geolocation {
                background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB0AAAAdCAMAAABhTZc9AAAAmVBMVEUAAAAAAABVVVVAQEAzMzMzMzMxMTEvLy82NjY1NTUxMTE1NTU0NDQ0NDQzMzMzMzMyMjI0NDQzMzMzMzMzMzMyMjI0NDQzMzMzMzMzMzM0NDQzMzMzMzMzMzMzMzMyMjIzMzMyMjI0NDQzMzMyMjIzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzP///8fN+sWAAAAMXRSTlMAAgMEBRkaGyEiKissWVpvcHFyc3R1gIGCg4WGiIyNjqusra6xs7TY2drb9/j5+/z+umDGuAAAAAFiS0dEMkDSTMgAAADISURBVBgZ1cFZW4JAAIbRbxgFDVxiLHMhXDIXlub9/3+uhysV5b7O0T9ghkbd9mzVJZqVlC7UM711RaNaWT3ofcMxm2UnOFi1raknRpKZ1izVElVMpGQcSylVqHuOo9GHx88VnEl1y+wLMiUe8LE+KXZGV0PAaURjJAcMdGW2BZkSD/hYOcXG6JbjFGju8e8KLqS6F1VMpXj8IjnKvlpW1K+BpMD9sFCbPcA5f8sv8GX1wC4rGuXC6pkwLSnTvrrs2KibGRj9fb/Kmxdl6uZ50gAAAABJRU5ErkJggg==)
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-marker {
                background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB3aWR0aD0iMTlweCIgaGVpZ2h0PSJweCIgdmlld0JveD0iMCAwIDE5IDE5IiB2ZXJzaW9uPSIxLjEiPgo8ZyBpZD0ic3VyZmFjZTEiPgo8cGF0aCBzdHlsZT0iIHN0cm9rZTpub25lO2ZpbGwtcnVsZTpub256ZXJvO2ZpbGw6cmdiKDAlLDAlLDAlKTtmaWxsLW9wYWNpdHk6MTsiIGQ9Ik0gOS40NjQ4NDQgMTkuMDAzOTA2IEwgOC45MTQwNjIgMTguNTM1MTU2IEMgOC4xNTIzNDQgMTcuODk4NDM4IDEuNTExNzE5IDEyLjE2MDE1NiAxLjUxMTcxOSA3Ljk2MDkzOCBDIDEuNTExNzE5IDMuNTcwMzEyIDUuMDc0MjE5IDAuMDA3ODEyNSA5LjQ2NDg0NCAwLjAwNzgxMjUgQyAxMy44NTkzNzUgMC4wMDc4MTI1IDE3LjQyMTg3NSAzLjU3MDMxMiAxNy40MjE4NzUgNy45NjA5MzggQyAxNy40MjE4NzUgMTIuMTYwMTU2IDEwLjc4MTI1IDE3Ljg5ODQzOCAxMC4wMjM0MzggMTguNTM1MTU2IFogTSA5LjQ2NDg0NCAxLjcyNjU2MiBDIDYuMDIzNDM4IDEuNzM0Mzc1IDMuMjM0Mzc1IDQuNTE5NTMxIDMuMjMwNDY5IDcuOTYwOTM4IEMgMy4yMzA0NjkgMTAuNTk3NjU2IDcuMzIwMzEyIDE0LjgwODU5NCA5LjQ2NDg0NCAxNi43MzgyODEgQyAxMS42MTMyODEgMTQuODA4NTk0IDE1LjY5OTIxOSAxMC41OTM3NSAxNS42OTkyMTkgNy45NjA5MzggQyAxNS42OTkyMTkgNC41MTk1MzEgMTIuOTEwMTU2IDEuNzM0Mzc1IDkuNDY0ODQ0IDEuNzI2NTYyIFogTSA5LjQ2NDg0NCAxLjcyNjU2MiAiLz4KPHBhdGggc3R5bGU9IiBzdHJva2U6bm9uZTtmaWxsLXJ1bGU6bm9uemVybztmaWxsOnJnYigwJSwwJSwwJSk7ZmlsbC1vcGFjaXR5OjE7IiBkPSJNIDkuNDY0ODQ0IDExLjExNzE4OCBDIDcuNzIyNjU2IDExLjExNzE4OCA2LjMxMjUgOS43MDMxMjUgNi4zMTI1IDcuOTYwOTM4IEMgNi4zMTI1IDYuMjIyNjU2IDcuNzIyNjU2IDQuODA4NTk0IDkuNDY0ODQ0IDQuODA4NTk0IEMgMTEuMjEwOTM4IDQuODA4NTk0IDEyLjYyMTA5NCA2LjIyMjY1NiAxMi42MjEwOTQgNy45NjA5MzggQyAxMi42MjEwOTQgOS43MDMxMjUgMTEuMjEwOTM4IDExLjExNzE4OCA5LjQ2NDg0NCAxMS4xMTcxODggWiBNIDkuNDY0ODQ0IDYuMzg2NzE5IEMgOC41OTc2NTYgNi4zODY3MTkgNy44OTA2MjUgNy4wODk4NDQgNy44OTA2MjUgNy45NjA5MzggQyA3Ljg5MDYyNSA4LjgzNTkzOCA4LjU5NzY1NiA5LjUzOTA2MiA5LjQ2NDg0NCA5LjUzOTA2MiBDIDEwLjMzNTkzOCA5LjUzOTA2MiAxMS4wNDI5NjkgOC44MzU5MzggMTEuMDQyOTY5IDcuOTYwOTM4IEMgMTEuMDQyOTY5IDcuMDg5ODQ0IDEwLjMzNTkzOCA2LjM4NjcxOSA5LjQ2NDg0NCA2LjM4NjcxOSBaIE0gOS40NjQ4NDQgNi4zODY3MTkgIi8+CjwvZz4KPC9zdmc+Cg==)
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-marker-home {
                background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB3aWR0aD0iMTlweCIgaGVpZ2h0PSJweCIgdmlld0JveD0iMCAwIDE5IDE5IiB2ZXJzaW9uPSIxLjEiPgo8ZyBpZD0ic3VyZmFjZTEiPgo8cGF0aCBzdHlsZT0iIHN0cm9rZTpub25lO2ZpbGwtcnVsZTpub256ZXJvO2ZpbGw6cmdiKDAlLDAlLDAlKTtmaWxsLW9wYWNpdHk6MTsiIGQ9Ik0gOS41IDAuMDAzOTA2MjUgQyA2LjI5Njg3NSAwLjAwMzkwNjI1IDMuNDEwMTU2IDEuOTM3NSAyLjE4NzUgNC44OTQ1MzEgQyAwLjk2MDkzOCA3Ljg1NTQ2OSAxLjY0MDYyNSAxMS4yNjE3MTkgMy45MDYyNSAxMy41MjczNDQgTCA5LjUgMTguOTk2MDk0IEwgMTUuMDk3NjU2IDEzLjUxOTUzMSBDIDE3LjM2MzI4MSAxMS4yNTM5MDYgMTguMDM5MDYyIDcuODQ3NjU2IDE2LjgxMjUgNC44OTQ1MzEgQyAxNS41ODk4NDQgMS45MzM1OTQgMTIuNzAzMTI1IDAuMDAzOTA2MjUgOS41IDAuMDAzOTA2MjUgWiBNIDEzLjk4NDM3NSAxMi4zOTQ1MzEgTCA5LjUgMTYuNzg1MTU2IEwgNS4wMTk1MzEgMTIuMzk4NDM4IEMgMi41NTA3ODEgOS45MjU3ODEgMi41NTA3ODEgNS45MTc5NjkgNS4wMTk1MzEgMy40NDUzMTIgQyA3LjQ5MjE4OCAwLjk3MjY1NiAxMS41IDAuOTY4NzUgMTMuOTcyNjU2IDMuNDQxNDA2IEMgMTYuNDQ5MjE5IDUuOTEwMTU2IDE2LjQ1MzEyNSA5LjkxNzk2OSAxMy45ODQzNzUgMTIuMzk0NTMxIFogTSAxMi42Nzk2ODggNS44NzUgTCAxMC43MDMxMjUgNC4zNjMyODEgQyA5Ljk5MjE4OCAzLjgyNDIxOSA5LjAwNzgxMiAzLjgyNDIxOSA4LjMwMDc4MSA0LjM2MzI4MSBMIDYuMzIwMzEyIDUuODc1IEMgNS44MjgxMjUgNi4yNTM5MDYgNS41NDI5NjkgNi44MzIwMzEgNS41MzkwNjIgNy40NDkyMTkgTCA1LjUzOTA2MiAxMS4wODU5MzggTCAxMy40NjA5MzggMTEuMDg1OTM4IEwgMTMuNDYwOTM4IDcuNDQ5MjE5IEMgMTMuNDU3MDMxIDYuODMyMDMxIDEzLjE3MTg3NSA2LjI1MzkwNiAxMi42Nzk2ODggNS44NzUgWiBNIDExLjg3NSA5LjUgTCAxMC4yODkwNjIgOS41IEwgMTAuMjg5MDYyIDcuOTE0MDYyIEwgOC43MTA5MzggNy45MTQwNjIgTCA4LjcxMDkzOCA5LjUgTCA3LjEyNSA5LjUgTCA3LjEyNSA3LjQ0OTIxOSBDIDcuMTI1IDcuMzI0MjE5IDcuMTgzNTk0IDcuMjA3MDMxIDcuMjg1MTU2IDcuMTMyODEyIEwgOS4yNjE3MTkgNS42MjEwOTQgQyA5LjQwNjI1IDUuNTExNzE5IDkuNjAxNTYyIDUuNTExNzE5IDkuNzQyMTg4IDUuNjIxMDk0IEwgMTEuNzIyNjU2IDcuMTMyODEyIEMgMTEuODI0MjE5IDcuMjA3MDMxIDExLjg3ODkwNiA3LjMyNDIxOSAxMS44Nzg5MDYgNy40NDkyMTkgWiBNIDExLjg3NSA5LjUgIi8+CjwvZz4KPC9zdmc+Cg==)
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-distance {
                background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABMAAAATCAYAAAByUDbMAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAAAR4AAAEeAaBNKxMAAAFYSURBVDhPpdS9K0VxHMfx4ykkJSZ5SJJF5E9gMmGUZDDIYrORMhj9AywGGWTAZLUYDSgP5bEIJc9l8Ph+655yus7lHp963ds5955zfr/v7/s7ecH/Uot2lOPWE0lTiHW84hHjSJxmvOEjZT+Xj2xiWeowjFMc4h2ObimHj7jkowEVOMIDRtCPJ/SiGH04wTxi04ktXGMFFtsLhlCPrGa1CqdgPZxGB8rgiH9MprtvwpsYV8v63CE8l5ZMfbYLf7/EDDbwjMRx5C7AGKYRO0XzWxGt2Q1cvR4MIDZ/3U6uahNskQP4ECWO22cUy5iEK5s43XhB2CqDiMSaNWIRc2jF97hDalIqEZbFb4/TsoBws+6hGhNYwxnsrVlUwd67wg7cEZH4ZP/Q8nUUBPdoQxeKcIFzHGMbpXAhXARv6gAi8Q1gh9uQUyhACTL2VFy82HeTrxZXLGGC4BO7pUzW1jQBPgAAAABJRU5ErkJgghvcdYG5gYsGPANLmaRbwI4PZjg9avpzY2aXkhaAPW9/YmZvwxicZxh0gFlgBdgApvMMQjAQ42lNlBaFWmNmX8Oo5sE3duGNYSkTueIAAAAASUVORK5CYII=)
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-car {
                background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiIHdpZHRoPSIxOXB4IiBoZWlnaHQ9IjE5cHgiIHZpZXdCb3g9IjAgMCAxOSAxOSIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMTkgMTkiIHhtbDpzcGFjZT0icHJlc2VydmUiPiAgPGltYWdlIGlkPSJpbWFnZTAiIHdpZHRoPSIxOSIgaGVpZ2h0PSIxOSIgeD0iMCIgeT0iMCIKICAgIGhyZWY9ImRhdGE6aW1hZ2UvcG5nO2Jhc2U2NCxpVkJPUncwS0dnb0FBQUFOU1VoRVVnQUFBQk1BQUFBVENBUUFBQURZV2Y1SEFBQUFCR2RCVFVFQUFMR1BDL3hoQlFBQUFDQmpTRkpOCkFBQjZKZ0FBZ0lRQUFQb0FBQUNBNkFBQWRUQUFBT3BnQUFBNm1BQUFGM0NjdWxFOEFBQUFBbUpMUjBRQS80ZVB6TDhBQUFBSmNFaFoKY3dBQUFMRUFBQUN4QWNZdFNZMEFBQUFIZEVsTlJRZm1DUlVIRlJQUVdpYXNBQUFCR0VsRVFWUW96NjNSdnkrRFVSVEc4VStyRFVMVQp3RXBFQkJNR25ReEl1cGhJL0EwUzZVSWlNWXJOWnZCSDBNRmdzWXBhUk5KUmlKOFJJMFBEb0lLOGh0ZGJiN1VSZytjdTU1ejd6WFBQCk9aZi9WS0lhTmNYaVNJR1BXbXpZdWlFSlFjd2djRzdOR2FSQTJwS2NVMjgxWG1rNVpmbnY2b2hMQmEwL25teXg0OG9vSk1HY2pHMHYKUDdDS2dveTVLTzFYVk5UV1lNQTJoNDcwaDcyTkc3TW5GMDBWVTVON3M3S3VJUy80OWVSRHR3REw3cVM4MWl5azJidGVtNEpvSVp5WQoxMmZWUlJVYnRPSEdicGdrdjRydHBrenFqZlhWWTlLMDlqQ0ozTXBXZEN2RnNKSkZENTVyc1MxbExNVCtOZkNHem04c2dhd3o3M1VMClNSa083MU9vNE5LRXB6cXN3N0VCbGRDcHo1UkgrdzNkWm5RNWNPdHYrZ1JWWlU0d3pWTXkrd0FBQUNWMFJWaDBaR0YwWlRwamNtVmgKZEdVQU1qQXlNaTB3T1MweU1WUXdOVG95TVRveE9Tc3dNam93TU45aDM5TUFBQUFsZEVWWWRHUmhkR1U2Ylc5a2FXWjVBREl3TWpJdApNRGt0TWpGVU1EVTZNakU2TVRrck1ESTZNREN1UEdkdkFBQUFHWFJGV0hSVGIyWjBkMkZ5WlFCM2QzY3VhVzVyYzJOaGNHVXViM0puCm0rNDhHZ0FBQUFCSlJVNUVya0pnZ2c9PSIgLz4KPC9zdmc+Cg==)
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-bike {
                background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB3aWR0aD0iMTlweCIgaGVpZ2h0PSJweCIgdmlld0JveD0iMCAwIDE5IDE5IiB2ZXJzaW9uPSIxLjEiPgo8ZyBpZD0ic3VyZmFjZTEiPgo8cGF0aCBzdHlsZT0iIHN0cm9rZTpub25lO2ZpbGwtcnVsZTpub256ZXJvO2ZpbGw6cmdiKDAlLDAlLDAlKTtmaWxsLW9wYWNpdHk6MTsiIGQ9Ik0gMTEuMzk4NDM4IDEuNjY0MDYyIEMgMTAuNjA5Mzc1IDMuMDA3ODEyIDEyLjQyOTY4OCA0LjUxMTcxOSAxMy41MzkwNjIgMy40MDIzNDQgQyAxNC40ODgyODEgMi40NTMxMjUgMTMuODU1NDY5IDAuNzkyOTY5IDEyLjY2Nzk2OSAwLjc5Mjk2OSBDIDEyLjI2OTUzMSAwLjc5Mjk2OSAxMS43MTQ4NDQgMS4xODc1IDExLjM5ODQzOCAxLjY2NDA2MiBaIE0gMTEuMzk4NDM4IDEuNjY0MDYyICIvPgo8cGF0aCBzdHlsZT0iIHN0cm9rZTpub25lO2ZpbGwtcnVsZTpub256ZXJvO2ZpbGw6cmdiKDAlLDAlLDAlKTtmaWxsLW9wYWNpdHk6MTsiIGQ9Ik0gNy42Nzk2ODggNC41ODk4NDQgQyA2LjAxNTYyNSA2LjQxNDA2MiA1LjkzNzUgOC4yMzQzNzUgNy41MTk1MzEgOS41IEMgOC4xNTIzNDQgMTAuMDU0Njg4IDguNzA3MDMxIDExLjMyMDMxMiA4LjcwNzAzMSAxMi4zNTE1NjIgQyA4LjcwNzAzMSAxMy4zNzg5MDYgOS4xMDU0NjkgMTQuMjUgOS41IDE0LjI1IEMgMTAuNTI3MzQ0IDE0LjI1IDEwLjUyNzM0NCAxMC4wNTQ2ODggOS41IDkuMDIzNDM4IEMgOC44NjcxODggOC4zOTA2MjUgOS4wMjM0MzggNy44MzU5MzggOS44OTQ1MzEgNy4xMjUgQyAxMC44NDc2NTYgNi4zMzIwMzEgMTEuMzk4NDM4IDYuMzMyMDMxIDEyLjAzNTE1NiA2Ljk2NDg0NCBDIDEzLjA2MjUgNy45OTYwOTQgMTUuMDQyOTY5IDguMjM0Mzc1IDE1LjA0Mjk2OSA3LjI4NTE1NiBDIDE1LjA0Mjk2OSA2Ljg4NjcxOSAxMS45NTMxMjUgNC42NzE4NzUgOS40MjE4NzUgMy4zMjQyMTkgQyA5LjE4MzU5NCAzLjI0NjA5NCA4LjM5MDYyNSAzLjgwMDc4MSA3LjY3OTY4OCA0LjU4OTg0NCBaIE0gNy42Nzk2ODggNC41ODk4NDQgIi8+CjxwYXRoIHN0eWxlPSIgc3Ryb2tlOm5vbmU7ZmlsbC1ydWxlOm5vbnplcm87ZmlsbDpyZ2IoMCUsMCUsMCUpO2ZpbGwtb3BhY2l0eToxOyIgZD0iTSAxLjc0MjE4OCAxMC40NDkyMTkgQyAwLjU1NDY4OCAxMS42MzY3MTkgMC41NTQ2ODggMTQuNDg4MjgxIDEuNzQyMTg4IDE1LjY3NTc4MSBDIDIuOTI5Njg4IDE2Ljg2MzI4MSA1Ljc3NzM0NCAxNi44NjMyODEgNi45NjQ4NDQgMTUuNjc1NzgxIEMgOS4xODM1OTQgMTMuNDU3MDMxIDcuNTE5NTMxIDkuNSA0LjM1NTQ2OSA5LjUgQyAzLjQwMjM0NCA5LjUgMi4yOTY4NzUgOS44OTQ1MzEgMS43NDIxODggMTAuNDQ5MjE5IFogTSA2LjE3NTc4MSAxMi45MDIzNDQgQyA2LjQ5MjE4OCAxNC40ODgyODEgNC4xOTUzMTIgMTUuNTk3NjU2IDMuMDA3ODEyIDE0LjQxMDE1NiBDIDEuODIwMzEyIDEzLjIyMjY1NiAyLjkyOTY4OCAxMC45MjU3ODEgNC41MTE3MTkgMTEuMjQyMTg4IEMgNS4zMDQ2ODggMTEuMzk4NDM4IDYuMDE1NjI1IDEyLjExMzI4MSA2LjE3NTc4MSAxMi45MDIzNDQgWiBNIDYuMTc1NzgxIDEyLjkwMjM0NCAiLz4KPHBhdGggc3R5bGU9IiBzdHJva2U6bm9uZTtmaWxsLXJ1bGU6bm9uemVybztmaWxsOnJnYigwJSwwJSwwJSk7ZmlsbC1vcGFjaXR5OjE7IiBkPSJNIDEyLjAzNTE1NiAxMC40NDkyMTkgQyA5LjgxNjQwNiAxMi42Njc5NjkgMTEuNDgwNDY5IDE2LjYyNSAxNC42NDQ1MzEgMTYuNjI1IEMgMTcuODEyNSAxNi42MjUgMTkuNDc2NTYyIDEyLjY2Nzk2OSAxNy4yNTc4MTIgMTAuNDQ5MjE5IEMgMTYuNzAzMTI1IDkuODk0NTMxIDE1LjU5NzY1NiA5LjUgMTQuNjQ0NTMxIDkuNSBDIDEzLjY5NTMxMiA5LjUgMTIuNTg1OTM4IDkuODk0NTMxIDEyLjAzNTE1NiAxMC40NDkyMTkgWiBNIDE2LjQ2NDg0NCAxMi45MDIzNDQgQyAxNi43ODUxNTYgMTQuNDg4MjgxIDE0LjQ4ODI4MSAxNS41OTc2NTYgMTMuMzAwNzgxIDE0LjQxMDE1NiBDIDEyLjExMzI4MSAxMy4yMjI2NTYgMTMuMjIyNjU2IDEwLjkyNTc4MSAxNC44MDQ2ODggMTEuMjQyMTg4IEMgMTUuNTk3NjU2IDExLjM5ODQzOCAxNi4zMDg1OTQgMTIuMTEzMjgxIDE2LjQ2NDg0NCAxMi45MDIzNDQgWiBNIDE2LjQ2NDg0NCAxMi45MDIzNDQgIi8+CjwvZz4KPC9zdmc+Cg==)
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-foot {
                background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB3aWR0aD0iMTlweCIgaGVpZ2h0PSJweCIgdmlld0JveD0iMCAwIDE5IDE5IiB2ZXJzaW9uPSIxLjEiPgo8ZyBpZD0ic3VyZmFjZTEiPgo8cGF0aCBzdHlsZT0iIHN0cm9rZTpub25lO2ZpbGwtcnVsZTpub256ZXJvO2ZpbGw6cmdiKDAlLDAlLDAlKTtmaWxsLW9wYWNpdHk6MTsiIGQ9Ik0gMTEuODc1IDMuNTYyNSBDIDEwLjY4NzUgNi42NDg0MzggMTIuMTkxNDA2IDkuNSAxNS4xMjEwOTQgOS41IEMgMTYuNzg1MTU2IDkuNSAxNy43MzQzNzUgNS4yMjY1NjIgMTYuNjI1IDMuMDg1OTM4IEMgMTUuNDM3NSAwLjk0OTIxOSAxMi43NDYwOTQgMS4xODc1IDExLjg3NSAzLjU2MjUgWiBNIDE1LjQzNzUgMy45NTcwMzEgQyAxNi4wNzAzMTIgNC45ODgyODEgMTUuMTk5MjE5IDcuOTE3OTY5IDE0LjI1IDcuOTE3OTY5IEMgMTMuMzAwNzgxIDcuOTE3OTY5IDEyLjY2Nzk2OSA1LjY5OTIxOSAxMy4xNDA2MjUgNC4zNTU0NjkgQyAxMy42OTUzMTIgMy4wMDc4MTIgMTQuNzI2NTYyIDIuNzY5NTMxIDE1LjQzNzUgMy45NTcwMzEgWiBNIDE1LjQzNzUgMy45NTcwMzEgIi8+CjxwYXRoIHN0eWxlPSIgc3Ryb2tlOm5vbmU7ZmlsbC1ydWxlOm5vbnplcm87ZmlsbDpyZ2IoMCUsMCUsMCUpO2ZpbGwtb3BhY2l0eToxOyIgZD0iTSA0LjExNzE4OCA1LjY5OTIxOSBDIDMuNTYyNSA2LjI1MzkwNiAzLjE2Nzk2OSA3Ljk5NjA5NCAzLjE2Nzk2OSA5LjY2MDE1NiBDIDMuMTY3OTY5IDEyLjQyOTY4OCAzLjMyNDIxOSAxMi42Njc5NjkgNS40NjA5MzggMTIuNjY3OTY5IEMgNy4zNjMyODEgMTIuNjY3OTY5IDcuOTE3OTY5IDEyLjI2OTUzMSA4LjMxMjUgMTAuMzcxMDk0IEMgOS4xODM1OTQgNi4zMzIwMzEgNi40OTIxODggMy4zMjQyMTkgNC4xMTcxODggNS42OTkyMTkgWiBNIDYuOTY0ODQ0IDkuMTgzNTk0IEMgNi41NzAzMTIgMTEuMzk4NDM4IDQuNzUgMTEuNDgwNDY5IDQuNzUgOS4yNjE3MTkgQyA0Ljc1IDguMjM0Mzc1IDQuOTg4MjgxIDcuMTI1IDUuMzA0Njg4IDYuODA4NTk0IEMgNi4wOTc2NTYgNi4wMTU2MjUgNy4yODUxNTYgNy42MDE1NjIgNi45NjQ4NDQgOS4xODM1OTQgWiBNIDYuOTY0ODQ0IDkuMTgzNTk0ICIvPgo8cGF0aCBzdHlsZT0iIHN0cm9rZTpub25lO2ZpbGwtcnVsZTpub256ZXJvO2ZpbGw6cmdiKDAlLDAlLDAlKTtmaWxsLW9wYWNpdHk6MTsiIGQ9Ik0gMTEuNTU4NTk0IDExLjAwMzkwNiBDIDExLjI0MjE4OCAxMS4zOTg0MzggMTEuNjM2NzE5IDEyLjM1MTU2MiAxMi4zNTE1NjIgMTMuMDYyNSBDIDEzLjUzOTA2MiAxNC4yNSAxMy43NzM0MzggMTQuMjUgMTQuODgyODEyIDEzLjE0MDYyNSBDIDE1LjU5NzY1NiAxMi40Mjk2ODggMTUuOTkyMTg4IDExLjc5Njg3NSAxNS43NTM5MDYgMTEuNTU4NTk0IEMgMTQuODA0Njg4IDEwLjc2NTYyNSAxMS45NTMxMjUgMTAuMjkyOTY5IDExLjU1ODU5NCAxMS4wMDM5MDYgWiBNIDExLjU1ODU5NCAxMS4wMDM5MDYgIi8+CjxwYXRoIHN0eWxlPSIgc3Ryb2tlOm5vbmU7ZmlsbC1ydWxlOm5vbnplcm87ZmlsbDpyZ2IoMCUsMCUsMCUpO2ZpbGwtb3BhY2l0eToxOyIgZD0iTSAzLjMyNDIxOSAxNS41OTc2NTYgQyAzLjcyMjY1NiAxNy42NTIzNDQgNi4wOTc2NTYgMTcuODEyNSA3LjEyNSAxNS45MTQwNjIgQyA3LjkxNzk2OSAxNC40MTAxNTYgNy43NTc4MTIgMTQuMjUgNS41NDI5NjkgMTQuMjUgQyAzLjU2MjUgMTQuMjUgMy4wODU5MzggMTQuNTY2NDA2IDMuMzI0MjE5IDE1LjU5NzY1NiBaIE0gMy4zMjQyMTkgMTUuNTk3NjU2ICIvPgo8L2c+Cjwvc3ZnPgo=)
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ekmap-container span {
                display: block;
                font-size: 13px;
                line-height: 1.4em;
                color: #3c434a;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-vehicle,
            #map_ekmap_<?php echo esc_attr($id_map); ?> .input-group input {
                line-height: 2;
                min-height: 30px;
                color: #2c3338;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-panel {
                background: #fff;
                box-shadow: 0 0 50px -30px #000;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .flex-center.left {
                left: 0;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-dr-content {
                padding: 0 10px;
                overflow: auto;
                height: calc(100% - 60px);
                cursor: default;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-close,
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-left,
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-right,
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-straight {
                background-position: 50%;
                background-repeat: no-repeat;
                height: 100%;
                width: 100%;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-sidebar-toggle.left {
                right: -1.5em;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-sidebar-toggle:hover {
                color: #0aa1cf;
                cursor: pointer;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-sidebar {
                transition: transform .5s;
                width: 25%;
                height: calc(100% - 175px);
                min-width: 180px;
                position: absolute;
                z-index: 2;
                font-style: normal;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ekmap-direction,
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ekmap-direction-title-h3 {
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                font-style: normal;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-left.ek-collapsed {
                transform: translateX(-150%);
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-straight {
                background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYBAMAAAASWSDLAAAAMFBMVEUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABHcEx/v/MDAAAAEHRSTlP/mQOvpwYwXmZF+78LxMUACy1w+AAAAFtJREFUGNNj+I8EGMCkehGC89WAOR7OCWZgMIJxPjkwMLDoQzkqDEDgBOU4gDgsEM5PBm4Hlg0M88GcbwveCDCe5cqHKMuIF2D82ga3VIARyQUDz2ngwBEgMAAAQ73igLCp+BcAAAAASUVORK5CYII=)
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-left {
                background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAMAAADXqc3KAAAAS1BMVEUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABHcEzD4NV8AAAAGXRSTlP/74xzEDQi4fca5irTBchOaoY/gq5dRaoAuG9o8AAAAIBJREFUKM/l0VcOwyAQBNDBBpvmXrL3P2kWrCVB4QaZLzRPlBWgnCF6Q1Xw9CPQNSD1trEj9zv9gOMeVuX4+XAFVlSxvcCgasEmdxgWtesUt8wsi7wqS3jOnk4gljmSyBya10GAjLe3PPQFXAVo0mWCDug/8JX/hQ1YmxDGyN/7BmRrKGH8imS5AAAAAElFTkSuQmCC)
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-right {
                background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAAsQAAALEBxi1JjQAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAD4SURBVEiJ7dO9SgNBFMXxn1+FYCOIhaigFoJgJVqKjZ2FL2Brap/CTt/DwhfwCewEwVYMooggBEWJILFIirvBnexmTbcHLtyBM/9zZ5hheG3jCTdYrcDJ1Tk6vXoYRcgOPkcdsouPENLEWjSMJTYv4hj7WMZ0jm8GU2Hd1D3dS2qyE9njl61GCn5aAdzBG1by4Ad95mscYgGzf9QeWn3wrdT0t8F8KXu3/VrHaxn4ZjC3ehOmdFYGDkdhw8Ugs+7r+sJzCj4Z+rnQPxYIuMI82vguEjAR+p8CAfA+yDBeEDS06oA6oA7IBrRDn/v1q2gJd7jHxn9BfwGMj1gNFk1UegAAAABJRU5ErkJggg==)
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-close {
                background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAPCAYAAAA71pVKAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAAALEAAACxAcYtSY0AAAEcSURBVDhPfdK5SgRBEIDh9lZkIyOfS/AJ1MDERDQzEC8WRAQDDYVl8TUUzDU08AVMhFXwPv5/2JKhdtyCL5iaqe7q6inEJu6whjETQ2IWB7jBgol7/OAdu5hEU1h4gU/4/SXKOiw08YJ95A58PkMU9rCI6oWtWOiLbxwiOmjhHOajcAWjqGIK7vgFP3jrP0/Awg9EZ0v4K4ww0cYr/NCj3CJ2fMIqRtAYtroDd7YguKOFAzvmsFWvol58jXEMjTyc4PMxptEYTj0Px7uMhZzBEQY68Ac4RR6OC+Yhxi1UYWEX8QPk4eQh2tkJZlC1Uv9zvMd8HS60hTiSC22jPPYTFi7jv+vwrPUjPHgmk3PYQAeeuynMX+EZ86WUvV9wTWa8MMvUngAAAABJRU5ErkJggltHdgAAAABJRU5ErkJggg==);
                cursor: pointer;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ekmap-direction-title {
                border-bottom: 1px solid #dddada;
                height: 40px;
                display: flex;
                align-items: center;
                padding: 0 10px;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ekmap-direction-title h3 {
                margin: 0 !important;
                font-size: 18px !important;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ekmap-direction-form {
                display: flex;
                width: 100%;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ekmap-direction-form-from,
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ekmap-direction-form-to {
                width: 50%;
                height: 100%;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ekmap-direction-form-from {
                padding: 0 20px 0 10px;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ekmap-direction-form-to {
                padding: 0 10px 0 20px;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .input-group {
                display: flex;
                width: 100%;
                align-items: stretch;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-dr-from,
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-dr-to {
                border-radius: 5px 0 0 5px !important;
                border-right: 0 !important;
                margin-top: 5px !important;
                border-color: #b1b1b1 !important;
                width: calc(100% - 30px) !important
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-swap {
                display: flex;
                width: 20px;
                height: 20px;
                position: absolute;
                margin-top: 10px;
                margin-left: -29px;
                cursor: pointer;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-geolocate,
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-geolocate2,
            #map_ekmap_<?php echo esc_attr($id_map); ?> .input-group input {
                background-color: #fff !important;
                height: 30px !important;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-geolocate,
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-geolocate2 {
                display: flex;
                border-radius: 0 5px 5px 0 !important;
                margin-top: 5px !important;
                margin-left: -2px !important;
                padding: 0 !important;
                width: 30px !important;
                cursor: pointer !important;
                font-size: 16px !important;
                box-sizing: border-box !important;
                border: 1px outset #b1b1b1 !important;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-vehicle {
                max-width: unset !important;
                border-radius: 5px !important;
                margin-top: 5px !important;
                border-color: #b1b1b1 !important;
                width: 100%;
                outline: 0;
                font-size: 14px;
                box-shadow: none;
                padding: 0 24px 0 8px;
                -webkit-appearance: none;
                background: url(data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2220%22%20height%3D%2220%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M5%206l5%205%205-5%202%201-7%207-7-7%202-1z%22%20fill%3D%22%23555%22%2F%3E%3C%2Fsvg%3E) right 5px top 55%/16px 16px no-repeat #fff;
                cursor: pointer;
                vertical-align: middle;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ekmap-direction {
                z-index: 1;
                position: absolute;
                bottom: 0;
                background-color: #f9f9f9;
                padding: 5px 5px 10px;
                height: 175px;
                width: 100%;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-dr-header {
                height: 60px;
                padding: 13px 10px 0 15px;
                display: flex;
                border: 0 outset;
                border-bottom: 1px solid grey;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-dr-h-text {
                width: calc(100% - 10px);
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-dr-h-text span {
                display: block;
                text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden;
                font-size: 13px;
                line-height: 20px;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-dr-cls-btn {
                display: flex;
                width: 14px;
                height: 14px;
                position: absolute;
                right: 5px;
                top: 5px;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-step-details {
                display: flex;
                width: 100%;
                min-height: 50px;
                flex-wrap: wrap;
                align-items: center;
                border: 0 outset;
                border-bottom: 1px solid #9b9b9b33;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-step-icon {
                display: flex;
                width: 40px;
                height: 40px;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-step-info {
                width: calc(100% - 40px);
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .direct_popup_ekmap {
                font-size: 12px;
                padding: 0px;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-dr-icon {
                width: 20px !important;
                height: 20px !important;
                margin-right: 5px !important;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ekdrt_ul {
                list-style: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            #map_ekmap_<?php echo esc_attr($id_map); ?> .ekdrt_ul li {
                margin: 5px 0;
                font-style: normal;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .input-group input {
                width: 100% !important;
                border-radius: 5px 0 0 5px !important;
                margin-top: 5px !important;
                box-shadow: none !important;
                outline: 0 !important;
                padding: 0 8px !important;
                border: 1px solid #8c8f94 !important;
                font-size: 14px !important;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-dr-text {
                width: calc(100% - 20px);
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-icon-swap {
                background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAAALEAAACxAcYtSY0AAAEsSURBVDhPvdQ/SwJxHMfxU4MokZZoDorEpAYJTBpa2oUegODk4Cw4i0NjbUVPoAcQPYMIgoaCbCmIJnERNSLtz/X+2KUZV3f2Ez/w4nf/+N33d/e9s35J0BmHTsgZvyeGLBqo6YBJkjiDJsvogEnWcIl3nGAWQyfgjOs4wAoesIsWvKLVVD43+5lAGarMxgvaPmnCSfSiCmUTO9Cyn3CEW3jlBsdQIQNRmyRwijfoonkYRZUu4ByPyGEk0dstQf04tmzjEFF8dYpR1BUdXCCF3qfq9un5yTVeoUrjuEIV9s9ydac9qMG9EsYiIrjHljMORCfrUJP7pR6UDQTcHugytIy/opUsIY8p6AWpM5r4V9K4g/5KBczAKPt4RhHGkylzWMV0d29EcXn+lvUB0pBILybcOXYAAAAASUVORK5CYII=);
                height: 100%;
                width: 100%;
                background-position: 50%;
                background-repeat: no-repeat;
                cursor: pointer;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ekmap-popup-hide {
                display: none !important;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .maplibregl-ctrl.maplibregl-ctrl-group.mapboxgl-ctrl.mapboxgl-ctrl-group button {
                margin: unset;
                padding: unset;
            }
            #map_ekmap_<?php echo esc_attr($id_map); ?> .ekmap-direction-title-h3 {
                font-weight: 600;
                font-size: 18px;
            }
            @media screen and (max-width:768px) {
                #map_ekmap_<?php echo esc_attr($id_map); ?> .ekmap-direction {
                    height: 35% !important;
                    min-height: 175px!important;
                }
                #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-sidebar {
                    width: 100%;
                    height: 40%;
                    bottom: 0;
                }
                #map_ekmap_<?php echo esc_attr($id_map); ?> .ek-collapsed {
                    transform: translateY(150%) !important;
                }
                #map_ekmap_<?php echo esc_attr($id_map); ?> .maplibregl-popup {
                    max-width: 200px !important;
                }
            }
        </style>

        <script>
            ( function($) {
                "use strict"
                var api_key = '<?php echo esc_attr(get_option('ekmap_field')); ?>';
                var arr_markers_<?php echo esc_attr($id_map); ?> = [];
                var marker_<?php echo esc_attr($id_map); ?>;
                var mapMarkers_<?php echo esc_attr($id_map); ?> = [];
                var map_<?php echo esc_attr($id_map); ?>,mapOSMBrigth_<?php echo esc_attr($id_map); ?>,mapOSMGray_<?php echo esc_attr($id_map); ?>,mapOSMDark_<?php echo esc_attr($id_map); ?>,mapOSMNight_<?php echo esc_attr($id_map); ?>,mapOSMStandard_<?php echo esc_attr($id_map); ?>;
                var mapOSMPencil_<?php echo esc_attr($id_map); ?>, mapOSMPirates_<?php echo esc_attr($id_map); ?>,mapOSMWood_<?php echo esc_attr($id_map); ?>,mapBDM_<?php echo esc_attr($id_map); ?>;
                var mapMarkers_open_<?php echo esc_attr($id_map); ?> = [];
                var geolocate_<?php echo esc_attr($id_map); ?>;
                var currentPosition_<?php echo esc_attr($id_map); ?> = [];
                var markerFrom_<?php echo esc_attr($id_map); ?>, markerTo_<?php echo esc_attr($id_map); ?>, popupDr_<?php echo esc_attr($id_map); ?>;
                var count_<?php echo esc_attr($id_map); ?> = 0;
                $('#map_ekmap_<?php echo esc_attr($id_map); ?>').addClass('<?php echo esc_attr($class_); ?>');
                <?php
                $query_marker = new WP_Query(array(
                    'post_type' => 'ekmap_marker',
                    'posts_per_page' => 10,
                    'fields'     => 'all',
                    'order' => 'ASC',
                    'meta_query'	=> array(
                        'relation'		=> 'AND',
                        array(
                            'key'		=> 'ekmap_marker_id',
                            'value'		=> sanitize_text_field($id_map),
                            'compare'	=> '='
                        )
                    )
                ));
                if($query_marker->have_posts()) : while ($query_marker->have_posts()) : $query_marker->the_post();
                ?>
                arr_markers_<?php echo esc_attr($id_map); ?>.push({
                    title: '<?php echo esc_attr(get_the_title()); ?>',
                    content: '<?php echo html_entity_decode(get_post_meta( get_the_ID(), 'ekmap_marker_content', true )); ?>',
                    color: '<?php echo esc_attr(get_post_meta( get_the_ID(), 'ekmap_marker_icon', true )); ?>',
                    image: '<?php echo esc_attr(get_post_meta( get_the_ID(), 'ekmap_marker_icon_img', true )); ?>',
                    width: '<?php echo esc_attr(get_post_meta( get_the_ID(), 'ekmap_marker_icon_width', true )); ?>',
                    height: '<?php echo esc_attr(get_post_meta( get_the_ID(), 'ekmap_marker_icon_height', true )); ?>',
                    phone: '<?php echo esc_attr(get_post_meta( get_the_ID(), 'ekmap_marker_phone', true )); ?>',
                    lon: '<?php echo esc_attr(get_post_meta( get_the_ID(), 'ekmap_marker_lon', true )); ?>',
                    lat: '<?php echo esc_attr(get_post_meta( get_the_ID(), 'ekmap_marker_lat', true )); ?>',
                    button_text: '<?php echo esc_attr(get_post_meta( get_the_ID(), 'ekmap_marker_text_button', true )); ?>',
                    button_color: '<?php echo esc_attr(get_post_meta( get_the_ID(), 'ekmap_marker_text_button_color', true )); ?>',
                    button_ground: '<?php echo esc_attr(get_post_meta( get_the_ID(), 'ekmap_marker_text_button_ground', true )); ?>',
                    link: '<?php echo esc_url(get_post_meta( get_the_ID(), 'ekmap_marker_link', true )); ?>',
                    id: <?php echo esc_attr(get_the_ID()); ?>,
                    open: '<?php echo esc_attr(get_post_meta( get_the_ID(), 'ekmap_marker_open', true )); ?>',
                });
                <?php
                endwhile;
                endif;
                wp_reset_query();
                ?>
                function changeStyleMap(styleMap, theme, direction) {
                    if($("#map_ekmap_<?php echo esc_attr($id_map); ?>").length > 0){
                        $('#map_ekmap_<?php echo esc_attr($id_map); ?>').empty();
                        $('#map_ekmap_<?php echo esc_attr($id_map); ?>').css('width', '<?php echo esc_attr($width_); ?>');
                        $('#map_ekmap_<?php echo esc_attr($id_map); ?>').css('height', '<?php echo esc_attr($height_); ?>');
                        let lat = '<?php echo esc_attr($lon_); ?>';
                        let lon = '<?php echo esc_attr($lat_); ?>';
                        map_<?php echo esc_attr($id_map); ?> = new maplibregl.Map({
                            container: 'map_ekmap_<?php echo esc_attr($id_map); ?>',
                            center: [lat, lon],
                            zoom: '<?php echo esc_attr($zoom_); ?>',
                            cooperativeGestures: true,
                            bearing:'<?php echo esc_attr($bearing_) ? : "0" ?>',
                            pitch:'<?php echo esc_attr($pitch_) ? : "0" ?>',
                        });
                        if(theme == 1){
                            mapOSMStandard_<?php echo esc_attr($id_map); ?> = new ekmapplf.VectorBaseMap('OSM:Standard', api_key);
                            mapOSMBrigth_<?php echo esc_attr($id_map); ?> = new ekmapplf.VectorBaseMap('OSM:Bright', api_key);
                            mapOSMGray_<?php echo esc_attr($id_map); ?> = new ekmapplf.VectorBaseMap('OSM:Gray', api_key);
                            mapOSMDark_<?php echo esc_attr($id_map); ?> = new ekmapplf.VectorBaseMap('OSM:Dark', api_key);
                            mapOSMNight_<?php echo esc_attr($id_map); ?> = new ekmapplf.VectorBaseMap('OSM:Night', api_key);
                            mapOSMPencil_<?php echo esc_attr($id_map); ?> = new ekmapplf.VectorBaseMap('OSM:Pencil', api_key);
                            mapOSMPirates_<?php echo esc_attr($id_map); ?> = new ekmapplf.VectorBaseMap('OSM:Pirates', api_key);
                            mapOSMWood_<?php echo esc_attr($id_map); ?> = new ekmapplf.VectorBaseMap('OSM:Wood', api_key);
                            mapBDM_<?php echo esc_attr($id_map); ?> = new ekmapplf.VectorBaseMap('BDM:Basic', api_key);

                            var basemap = new ekmapplf.control.BaseMap({
                                baseLayers: [
                                {
                                    id: "OSMStandard",
                                    title: '',
                                    thumbnail: "https://files.ekgis.vn/widget/v1.0.0/assets/image/map-chuan.png",
                                    width: "50px",
                                    height: "50px"
                                },
                                {
                                    id: "OSMBright",
                                    title: '',
                                    thumbnail: "https://files.ekgis.vn/widget/v1.0.0/assets/image/map-sang.png",
                                    width: "50px",
                                    height: "50px"
                                },
                                {
                                    id: "OSMGray",
                                    title: '',
                                    thumbnail: "https://files.ekgis.vn/widget/v1.0.0/assets/image/xam-map.png",
                                    width: "50px",
                                    height: "50px"
                                },
                                {
                                    id: "OSMNight",
                                    title: '',
                                    thumbnail: "https://files.ekgis.vn/widget/v1.0.0/assets/image/dem-map.png",
                                    width: "50px",
                                    height: "50px"
                                },
                                {
                                    id: "OSMDark",
                                    title: '',
                                    thumbnail: "https://files.ekgis.vn/widget/v1.0.0/assets/image/xanhcoban-map.png",
                                    width: "50px",
                                    height: "50px"
                                },
                                {
                                    id: "OSMPencil",
                                    title: '',
                                    thumbnail: "https://files.ekgis.vn/widget/v1.0.0/assets/image/chi-map.png",
                                    width: "50px",
                                    height: "50px"
                                },
                                {
                                    id: "OSMPirates",
                                    title: '',
                                    thumbnail: "https://files.ekgis.vn/widget/v1.0.0/assets/image/dien-map.png",
                                    width: "50px",
                                    height: "50px"
                                },
                                {
                                    id: "OSMWood",
                                    title: '',
                                    thumbnail: "https://files.ekgis.vn/widget/v1.0.0/assets/image/go-map.png",
                                    width: "50px",
                                    height: "50px"
                                },]
                            });
                            map_<?php echo esc_attr($id_map); ?>.addControl(basemap, 'bottom-left');
                            basemap.on('changeBaseLayer', function (response) {
                                if (response.layer == "OSMStandard") mapOSMStandard_<?php echo esc_attr($id_map); ?>.addTo(map_<?php echo esc_attr($id_map); ?>);
                                else if (response.layer == "OSMBright") mapOSMBrigth_<?php echo esc_attr($id_map); ?>.addTo(map_<?php echo esc_attr($id_map); ?>);
                                else if (response.layer == "OSMNight") mapOSMNight_<?php echo esc_attr($id_map); ?>.addTo(map_<?php echo esc_attr($id_map); ?>);
                                else if (response.layer == "OSMGray") mapOSMGray_<?php echo esc_attr($id_map); ?>.addTo(map_<?php echo esc_attr($id_map); ?>);
                                else if (response.layer == "OSMDark") mapOSMDark_<?php echo esc_attr($id_map); ?>.addTo(map_<?php echo esc_attr($id_map); ?>);
                                else if (response.layer == "OSMWood") mapOSMWood_<?php echo esc_attr($id_map); ?>.addTo(map_<?php echo esc_attr($id_map); ?>);
                                else if (response.layer == "OSMPirates") mapOSMPirates_<?php echo esc_attr($id_map); ?>.addTo(map_<?php echo esc_attr($id_map); ?>);
                                else if (response.layer == "OSMPencil") mapOSMPencil_<?php echo esc_attr($id_map); ?>.addTo(map_<?php echo esc_attr($id_map); ?>);
                            });
                        }else if(theme == 2){
                            mapOSMBrigth_<?php echo esc_attr($id_map); ?> = new ekmapplf.VectorBaseMap('CTM:Bright', api_key);
                            mapOSMGray_<?php echo esc_attr($id_map); ?> = new ekmapplf.VectorBaseMap('CTM:Gray', api_key);
                            mapOSMDark_<?php echo esc_attr($id_map); ?> = new ekmapplf.VectorBaseMap('CTM:Dark', api_key);
                            mapOSMNight_<?php echo esc_attr($id_map); ?> = new ekmapplf.VectorBaseMap('CTM:Night', api_key);
                        }else if(theme == 3){
                            mapOSMBrigth_<?php echo esc_attr($id_map); ?> = new ekmapplf.VectorBaseMap('BDM:Basic', api_key);
                            mapOSMGray_<?php echo esc_attr($id_map); ?> = new ekmapplf.VectorBaseMap('BDM:Basic', api_key);
                            mapOSMDark_<?php echo esc_attr($id_map); ?> = new ekmapplf.VectorBaseMap('BDM:Basic', api_key);
                            mapOSMNight_<?php echo esc_attr($id_map); ?> = new ekmapplf.VectorBaseMap('BDM:Basic', api_key);
                        }else if(theme == 4){
                            mapOSMBrigth_<?php echo esc_attr($id_map); ?> = new ekmapplf.layer.LandUse({'apiKey': api_key});
                            mapOSMGray_<?php echo esc_attr($id_map); ?> = new ekmapplf.layer.LandUse({'apiKey': api_key});
                            mapOSMDark_<?php echo esc_attr($id_map); ?> = new ekmapplf.layer.LandUse({'apiKey': api_key});
                            mapOSMNight_<?php echo esc_attr($id_map); ?> = new ekmapplf.layer.LandUse({'apiKey': api_key});
                        }else if(theme == 5){
                            mapOSMBrigth_<?php echo esc_attr($id_map); ?> = new ekmapplf.layer.Zoning({'apiKey': api_key});
                            mapOSMGray_<?php echo esc_attr($id_map); ?> = new ekmapplf.layer.Zoning({'apiKey': api_key});
                            mapOSMDark_<?php echo esc_attr($id_map); ?> = new ekmapplf.layer.Zoning({'apiKey': api_key});
                            mapOSMNight_<?php echo esc_attr($id_map); ?> = new ekmapplf.layer.Zoning({'apiKey': api_key});
                        }

                        switch (styleMap) {
                            case '0':
                                mapOSMStandard_<?php echo esc_attr($id_map); ?>.addTo(map_<?php echo esc_attr($id_map); ?>);
                                break;
                            case '1':
                                mapOSMBrigth_<?php echo esc_attr($id_map); ?>.addTo(map_<?php echo esc_attr($id_map); ?>);
                                break;
                            case '2':
                                mapOSMGray_<?php echo esc_attr($id_map); ?>.addTo(map_<?php echo esc_attr($id_map); ?>);
                                break;
                            case '3':
                                mapOSMDark_<?php echo esc_attr($id_map); ?>.addTo(map_<?php echo esc_attr($id_map); ?>);
                                break;
                            case '4':
                                mapOSMNight_<?php echo esc_attr($id_map); ?>.addTo(map_<?php echo esc_attr($id_map); ?>);
                                break;
                            case '5':
                                mapOSMPencil_<?php echo esc_attr($id_map); ?>.addTo(map_<?php echo esc_attr($id_map); ?>);
                                break;
                            case '6':
                                mapOSMPirates_<?php echo esc_attr($id_map); ?>.addTo(map_<?php echo esc_attr($id_map); ?>);
                                break;
                            case '7':
                                mapOSMWood_<?php echo esc_attr($id_map); ?>.addTo(map_<?php echo esc_attr($id_map); ?>);
                                break;
                            case '8':
                                mapBDM_<?php echo esc_attr($id_map); ?>.addTo(map_<?php echo esc_attr($id_map); ?>);
                                break;
                        }
                        if(direction==1){
                            var Map_el = document.getElementById('map_ekmap_<?php echo esc_attr($id_map); ?>');
                            var Left_el = document.createElement('div');
                            Left_el.id ='ek-left_<?php echo esc_attr($id_map); ?>';
                            Left_el.className = 'ek-sidebar ek-panel ek-left ek-collapsed';
                            Left_el.innerHTML=
                            `<div class="ek-dr-header"></div>`+
                            `<div class="ek-dr-content ekmap-scrollbar"></div>`;
                            Map_el.appendChild(Left_el);
                            var El_direct = document.createElement('div');
                            El_direct.className = 'ekmap-direction ekmap-direction_<?php echo esc_attr($id_map); ?>';
                            El_direct.innerHTML=
                            '<div class="ekmap-direction-title">'+
                                '<span class="ekmap-direction-title-h3">Chỉ đường</span>'+
                            '</div>'+
                            '<div class="ekmap-direction-form">'+
                                '<div class="ekmap-direction-form-from">'+
                                    '<ul class="ekdrt_ul">'+
                                        '<li>'+
                                            '<span>Điểm bắt đầu:</span>'+
                                            '<div class="input-group">'+
                                                '<input class="ek-dr-from ek-dr-from_<?php echo esc_attr($id_map); ?>" name="ek-dr-from_<?php echo esc_attr($id_map); ?>" type="text"placeholder="Chọn điểm bắt đầu"/>'+
                                                '<span class="ek-geolocate ek-geolocate_<?php echo esc_attr($id_map); ?>" name="ek-geolocate_<?php echo esc_attr($id_map); ?>" title="Lấy vị trí của bạn">'+
                                                    '<span class="ek-icon-geolocation" aria-hidden="true"></span>'+
                                                '</span>'+
                                            '</div>'+
                                        '</li>'+
                                        '<li>'+
                                            '<span>Phương tiện:</span>'+
                                            '<select class="ek-vehicle ek-vehicle_<?php echo esc_attr($id_map); ?>" name="ek-vehicle_<?php echo esc_attr($id_map); ?>">'+
                                            '<option value="car" selected>Lái xe</option>'+
                                            '<option value="bicycle">Xe đạp</option>'+
                                            '<option value="foot">Đi bộ</option>'+
                                            '</select>'+
                                        '</li>'+
                                    '</ul>'+
                                '</div>'+
                                '<div class="ekmap-direction-form-to">'+
                                    '<ul class="ekdrt_ul">'+
                                        '<li >'+
                                            '<span>Điểm kết thúc:</span>'+
                                            '<span class="ek-swap ek-swap_<?php echo esc_attr($id_map); ?>" name="ek-swap_<?php echo esc_attr($id_map); ?>" title="Đảo ngược điểm bắt đầu và điểm kết thúc"><span class="ek-icon-swap" aria-hidden="true"></span></span>' +
                                            '<div class="input-group">'+
                                                '<input class="ek-dr-to ek-dr-to_<?php echo esc_attr($id_map); ?>" name="ek-dr-to_<?php echo esc_attr($id_map); ?>" type="text" placeholder="Chọn điểm kết thúc"/>'+
                                                '<span class="ek-geolocate2 ek-geolocate2_<?php echo esc_attr($id_map); ?>" name="ek-geolocate2_<?php echo esc_attr($id_map); ?>" title="Lấy vị trí của bạn">'+
                                                    '<span class="ek-icon-geolocation" aria-hidden="true"></span>'+
                                                '</span>'+
                                            '</div>'+
                                        '</li>'+
                                    '</ul>'+
                                '</div>'+
                            '</div>';
                            Map_el.appendChild(El_direct);
                            Map_el.querySelector(".maplibregl-cooperative-gesture-screen").style.bottom='175px';
                            var Ctl_el = Map_el.querySelector(".maplibregl-control-container");
                            Ctl_el.querySelector('.maplibregl-ctrl-bottom-left').style.bottom='175px';
                            Ctl_el.querySelector('.maplibregl-ctrl-bottom-right').style.bottom='175px';
                            map_<?php echo esc_attr($id_map); ?>.setPadding({bottom:100});
                        }
                        // Controls
                        map_<?php echo esc_attr($id_map); ?>.addControl(new maplibregl.NavigationControl(), 'bottom-right');
                        
                        var is3DMap_<?php echo esc_attr($id_map); ?> = false;
                        if (map_<?php echo esc_attr($id_map); ?>.getPitch() > 0) is3DMap_<?php echo esc_attr($id_map); ?> = true;
                        else is3DMap_<?php echo esc_attr($id_map); ?> = false;
                        var cl = 'maplibregl-terrain2d-control';
                        var tl = 'Bản đồ 2D'
                        if (!is3DMap_<?php echo esc_attr($id_map); ?>) {
                            cl = 'maplibregl-terrain3d-control';
                            tl = 'Bản đồ 3D'
                        }
                        let btn3D_<?php echo esc_attr($id_map); ?> = new ekmapplf.control.Button({
                            className: cl,
                            icon:'none',
                            tooltip: tl
                        });
                        btn3D_<?php echo esc_attr($id_map); ?>.on('click', (btn) => {
                            is3DMap_<?php echo esc_attr($id_map); ?> = !is3DMap_<?php echo esc_attr($id_map); ?>;
                            if (is3DMap_<?php echo esc_attr($id_map); ?>){
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
                            if (is3DMap_<?php echo esc_attr($id_map); ?>) {
                                map_<?php echo esc_attr($id_map); ?>.easeTo({ pitch: 60 });
                                map_<?php echo esc_attr($id_map); ?>.setLayoutProperty(
                                    'building-3d',
                                    'visibility',
                                    'visible'
                                );
                            } else {
                                map_<?php echo esc_attr($id_map); ?>.easeTo({ pitch: 0 });
                                map_<?php echo esc_attr($id_map); ?>.setLayoutProperty(
                                    'building-3d',
                                    'visibility',
                                    'none'
                                );
                            }
                        });
                        map_<?php echo esc_attr($id_map); ?>.addControl(btn3D_<?php echo esc_attr($id_map); ?>, 'bottom-right');

                        geolocate_<?php echo esc_attr($id_map); ?>= new maplibregl.GeolocateControl({ positionOptions: { enableHighAccuracy: true }, trackUserLocation: false, showAccuracyCircle:false });
                        map_<?php echo esc_attr($id_map); ?>.addControl(geolocate_<?php echo esc_attr($id_map); ?>, 'bottom-right');
                        geolocate_<?php echo esc_attr($id_map); ?>.on('geolocate', function (evt) {
                            currentPosition_<?php echo esc_attr($id_map); ?> = [evt.coords.longitude, evt.coords.latitude];
                        })

                        map_<?php echo esc_attr($id_map); ?>.addControl(new maplibregl.FullscreenControl(), 'bottom-right');
                    }
                }
                setTimeout(function(){
                    changeStyleMap('<?php echo esc_attr($type_); ?>', '<?php echo esc_attr($theme_); ?>','<?php echo esc_attr($direction_) ? : "0"?>');
                    if(<?php echo esc_attr($direction_) ? : "0"?> ==1 && isMobileScreen_<?php echo esc_attr($id_map); ?>()){
                        document.getElementById('map_ekmap_<?php echo esc_attr($id_map); ?>').querySelector(".maplibregl-cooperative-gesture-screen").style.bottom='35%';
                        var Ctl_el = document.getElementById('map_ekmap_<?php echo esc_attr($id_map); ?>').querySelector(".maplibregl-control-container");
                        Ctl_el.querySelector('.maplibregl-ctrl-bottom-left').style.bottom='35%';
                        Ctl_el.querySelector('.maplibregl-ctrl-bottom-right').style.bottom='35%';
                    }
                    mapMarkers_<?php echo esc_attr($id_map); ?>.forEach((marker) => marker.remove())
                    mapMarkers_<?php echo esc_attr($id_map); ?> = [];
                    mapMarkers_open_<?php echo esc_attr($id_map); ?>.forEach((marker) => marker.remove())
                    mapMarkers_open_<?php echo esc_attr($id_map); ?> = [];
                    for(let i = 0; i < arr_markers_<?php echo esc_attr($id_map); ?>.length; i++){
                        let svg = '<svg display="block" style="margin: auto;" height="41px" width="27px" viewBox="0 0 27 41"><g fill-rule="nonzero"><g transform="translate(3.0, 29.0)" fill="#000000"><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="10.5" ry="5.25002273"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="10.5" ry="5.25002273"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="9.5" ry="4.77275007"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="8.5" ry="4.29549936"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="7.5" ry="3.81822308"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="6.5" ry="3.34094679"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="5.5" ry="2.86367051"></ellipse><ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="4.5" ry="2.38636864"></ellipse></g><g fill="'+arr_markers_<?php echo $id_map; ?>[i].color+'"><path d="M27,13.5 C27,19.074644 20.250001,27.000002 14.75,34.500002 C14.016665,35.500004 12.983335,35.500004 12.25,34.500002 C6.7499993,27.000002 0,19.222562 0,13.5 C0,6.0441559 6.0441559,0 13.5,0 C20.955844,0 27,6.0441559 27,13.5 Z"></path></g><g opacity="0.25" fill="'+arr_markers_<?php echo esc_attr($id_map); ?>[i].color+'"><path d="M13.5,0 C6.0441559,0 0,6.0441559 0,13.5 C0,19.222562 6.7499993,27 12.25,34.5 C13,35.522727 14.016664,35.500004 14.75,34.5 C20.250001,27 27,19.074644 27,13.5 C27,6.0441559 20.955844,0 13.5,0 Z M13.5,1 C20.415404,1 26,6.584596 26,13.5 C26,15.898657 24.495584,19.181431 22.220703,22.738281 C19.945823,26.295132 16.705119,30.142167 13.943359,33.908203 C13.743445,34.180814 13.612715,34.322738 13.5,34.441406 C13.387285,34.322738 13.256555,34.180814 13.056641,33.908203 C10.284481,30.127985 7.4148684,26.314159 5.015625,22.773438 C2.6163816,19.232715 1,15.953538 1,13.5 C1,6.584596 6.584596,1 13.5,1 Z"></path></g><g transform="translate(6.0, 7.0)" fill="#FFFFFF"></g><g transform="translate(8.0, 8.0)"><circle fill="'+arr_markers_<?php echo esc_attr($id_map); ?>[i].color+'" opacity="0.25" cx="5.5" cy="5.5" r="5.4999962"></circle><circle fill="#FFFFFF" cx="5.5" cy="5.5" r="5.4999962"></circle></g></g></svg>';
                        $('.ekmap_list_marker tbody').prepend('<tr><td>'+arr_markers_<?php echo esc_attr($id_map); ?>[i].title+'</td><td data-color="'+arr_markers_<?php echo esc_attr($id_map); ?>[i].color+'">'+svg+'</td><td>'+arr_markers_<?php echo esc_attr($id_map); ?>[i].phone+'</td><td>'+arr_markers_<?php echo esc_attr($id_map); ?>[i].lon+'</td><td>'+arr_markers_<?php echo esc_attr($id_map); ?>[i].lat+'</td><td>'+arr_markers_<?php echo esc_attr($id_map); ?>[i].link+'</td><td><div class="action"><a href="#" class="edit" data-id="'+arr_markers_<?php echo esc_attr($id_map); ?>[i].id+'" data-content="'+arr_markers_<?php echo esc_attr($id_map); ?>[i].content+'" data-phone="'+arr_markers_<?php echo esc_attr($id_map); ?>[i].phone+'" data-button="'+arr_markers_<?php echo esc_attr($id_map); ?>[i].button_text+'" data-btncolor="'+arr_markers_<?php echo esc_attr($id_map); ?>[i].button_color+'" data-btnground="'+arr_markers_<?php echo esc_attr($id_map); ?>[i].button_ground+'"><i class="fa fa-pencil" aria-hidden="true"></i></a><a href="#" class="remove_fix" data-id="'+arr_markers_<?php echo esc_attr($id_map); ?>[i].id+'"><i class="fa fa-trash" aria-hidden="true"></i></a></div></td></tr>');
                        let html = '';
                        html += '<div class="content_popup_ekmap">';
                        if(arr_markers_<?php echo esc_attr($id_map); ?>[i].image != ''){
                            html += '<img src="'+arr_markers_<?php echo esc_attr($id_map); ?>[i].image+'" alt="'+arr_markers_<?php echo esc_attr($id_map); ?>[i].title+'" width="'+arr_markers_<?php echo esc_attr($id_map); ?>[i].width+'" height="'+arr_markers_<?php echo esc_attr($id_map); ?>[i].height+'" />';
                        }
                        if(arr_markers_<?php echo esc_attr($id_map); ?>[i].title != ''){
                            html += '<h3>'+arr_markers_<?php echo esc_attr($id_map); ?>[i].title+'</h3>';
                        }
                        if(arr_markers_<?php echo esc_attr($id_map); ?>[i].content != ''){
                            html += '<p>'+arr_markers_<?php echo esc_attr($id_map); ?>[i].content+'</p>';
                        }
                        if(arr_markers_<?php echo esc_attr($id_map); ?>[i].phone != ''){
                            html += '<p><i class="fa fa-phone" aria-hidden="true"></i>\n '+arr_markers_<?php echo esc_attr($id_map); ?>[i].phone+'</p>';
                        }
                        let style_btn = '';
                        if(arr_markers_<?php echo esc_attr($id_map); ?>[i].button_color != ''){
                            style_btn += 'color: '+arr_markers_<?php echo esc_attr($id_map); ?>[i].button_color+';';
                        }
                        if(arr_markers_<?php echo esc_attr($id_map); ?>[i].button_ground != ''){
                            style_btn += 'background-color: '+arr_markers_<?php echo esc_attr($id_map); ?>[i].button_ground+';';
                        }
                        if(arr_markers_<?php echo esc_attr($id_map); ?>[i].button_text != ''){
                            html += '<p style="display:flex; justify-content: center;margin-bottom:0;"><a href="'+arr_markers_<?php echo esc_attr($id_map); ?>[i].link+'" style="'+style_btn+'">'+arr_markers_<?php echo esc_attr($id_map); ?>[i].button_text+'</a>';
                        }
						if(<?php echo esc_attr($direction_) ? : "0"?> !=0){
							if(arr_markers_<?php echo esc_attr($id_map); ?>[i].button_text == '') html += '<p style="display:flex; justify-content: center;margin-bottom:0;">';
							html += '<a class="ek-routing_<?php echo esc_attr($id_map); ?>" style="'+style_btn+'" data-lon="'+arr_markers_<?php echo esc_attr($id_map); ?>[i].lon+'" data-lat="'+arr_markers_<?php echo esc_attr($id_map); ?>[i].lat+'">Chỉ đường</a>';
							html += '</p>';
						}
						if(<?php echo esc_attr($direction_) ? : "0"?> ==0 && arr_markers_<?php echo esc_attr($id_map); ?>[i].button_text != ''){
							html += '</p>';
						}
                        html += '</div>';
                        const popup = new maplibregl.Popup({focusAfterOpen:false, closeOnClick: false, offset: 25 }).setHTML(html);
                        if(arr_markers_<?php echo esc_attr($id_map); ?>[i].lon != '' && arr_markers_<?php echo esc_attr($id_map); ?>[i].lat != ''){
                            marker_<?php echo esc_attr($id_map); ?> = new maplibregl.Marker({ color: arr_markers_<?php echo esc_attr($id_map); ?>[i].color })
                                .setLngLat([arr_markers_<?php echo esc_attr($id_map); ?>[i].lon, arr_markers_<?php echo esc_attr($id_map); ?>[i].lat])
                                .setPopup(popup)
                                .addTo(map_<?php echo esc_attr($id_map); ?>);
                            if(arr_markers_<?php echo esc_attr($id_map); ?>[i].open == 1){
                                var marker_open_<?php echo esc_attr($id_map); ?> = new maplibregl.Popup({focusAfterOpen:false, closeOnClick: false, offset: 25, closeButton:false, color: arr_markers_<?php echo esc_attr($id_map); ?>[i].color })
                                    .setLngLat([arr_markers_<?php echo esc_attr($id_map); ?>[i].lon, arr_markers_<?php echo esc_attr($id_map); ?>[i].lat])
                                    .setHTML(html)
                                    .addTo(map_<?php echo esc_attr($id_map); ?>);
                                mapMarkers_open_<?php echo esc_attr($id_map); ?>.push(marker_open_<?php echo esc_attr($id_map); ?>);
                            }
                            mapMarkers_<?php echo esc_attr($id_map); ?>.push(marker_<?php echo esc_attr($id_map); ?>);
                        }
                    }

                    //direction
                    var geocoding = new ekmapplf.service.Geocoding(api_key);
                    var routingService = new ekmapplf.service.Routing({apiKey: api_key, profile: $('.ek-vehicle_<?php echo esc_attr($id_map); ?>').val()});
                    if(<?php echo esc_attr($direction_) ? : "0"?> !=0){
                        mapMarkers_<?php echo esc_attr($id_map); ?>.forEach((marker) =>{
                            var popup=marker.getPopup();
                            popup._content.querySelector('.ek-routing_<?php echo esc_attr($id_map); ?>').addEventListener('click', () =>{
                                var lon = popup._lngLat.lng;
                                var lat = popup._lngLat.lat;
                                if(<?php echo esc_attr($direction_) ? : "0"?> ==1){
                                    RoutingtoCurrentPosition_<?php echo esc_attr($id_map); ?>(lon,lat);
                                    popup.remove();
                                }
                                if(<?php echo esc_attr($direction_) ? : "0"?> ==2){
                                    RoutingbyGG_<?php echo esc_attr($id_map); ?>(lon,lat);
                                }
                            })
                        });

                        mapMarkers_open_<?php echo esc_attr($id_map); ?>.forEach((popup) => popup.getElement().querySelector('.ek-routing_<?php echo esc_attr($id_map); ?>').addEventListener('click', () =>{
                            var lon = popup._lngLat.lng;
                            var lat = popup._lngLat.lat;
                            if(<?php echo esc_attr($direction_) ? : "0"?> ==1){
                                RoutingtoCurrentPosition_<?php echo esc_attr($id_map); ?>(lon,lat);
                            }
                            if(<?php echo esc_attr($direction_) ? : "0"?> ==2){
                                RoutingbyGG_<?php echo esc_attr($id_map); ?>(lon,lat);
                            }
                        }));

                        if(<?php echo esc_attr($direction_) ? : "0"?> ==1){
                            autocomplete_<?php echo esc_attr($id_map); ?>($('.ek-dr-from_<?php echo esc_attr($id_map); ?>')[0]); 
                            autocomplete_<?php echo esc_attr($id_map); ?>($('.ek-dr-to_<?php echo esc_attr($id_map); ?>')[0]);
                        }
                    }
                    
                    $(document).on('click', '.ek-geolocate_<?php echo esc_attr($id_map); ?>', function () {
                        if(currentPosition_<?php echo esc_attr($id_map); ?>.length==0) geolocate_<?php echo esc_attr($id_map); ?>.trigger();
                        setTimeout(function(){
                            var paramRever = {
                                'point.lon': currentPosition_<?php echo esc_attr($id_map); ?>[0],
                                'point.lat': currentPosition_<?php echo esc_attr($id_map); ?>[1]
                            }
                            geocoding.reverse(paramRever, function (error, response) {
                                if (response.status == 'OK'){
                                    $('.ek-dr-from_<?php echo esc_attr($id_map); ?>')[0].value = response.results[0].formatted_address;
                                    $('.ek-dr-from_<?php echo esc_attr($id_map); ?>')[0].setAttribute('data-lon',currentPosition_<?php echo esc_attr($id_map); ?>[0]);
                                    $('.ek-dr-from_<?php echo esc_attr($id_map); ?>')[0].setAttribute('data-lat',currentPosition_<?php echo esc_attr($id_map); ?>[1]);
                                    changeinput_<?php echo esc_attr($id_map); ?>();
                                }
                            })
                        },500)
                    });

                    $(document).on('click', '.ek-geolocate2_<?php echo esc_attr($id_map); ?>', function () {
                        if(currentPosition_<?php echo esc_attr($id_map); ?>.length==0) geolocate_<?php echo esc_attr($id_map); ?>.trigger();
                        setTimeout(function(){
                            var paramRever = {
                                'point.lon': currentPosition_<?php echo esc_attr($id_map); ?>[0],
                                'point.lat': currentPosition_<?php echo esc_attr($id_map); ?>[1]
                            }
                            geocoding.reverse(paramRever, function (error, response) {
                                if (response.status == 'OK'){
                                    $('.ek-dr-to_<?php echo esc_attr($id_map); ?>')[0].value = response.results[0].formatted_address;
                                    $('.ek-dr-to_<?php echo esc_attr($id_map); ?>')[0].setAttribute('data-lon',currentPosition_<?php echo esc_attr($id_map); ?>[0]);
                                    $('.ek-dr-to_<?php echo esc_attr($id_map); ?>')[0].setAttribute('data-lat',currentPosition_<?php echo esc_attr($id_map); ?>[1]);
                                    changeinput_<?php echo esc_attr($id_map); ?>()
                                }
                            })
                        },500)
                    });

                    $('.ek-vehicle_<?php echo esc_attr($id_map); ?>').on('change',function(){
                        changeinput_<?php echo esc_attr($id_map); ?>()
                    });

                    $('.ek-swap_<?php echo esc_attr($id_map); ?>').on('click', function () {
                        var text1= $('.ek-dr-from_<?php echo esc_attr($id_map); ?>').val();
                        var lon1= $('.ek-dr-from_<?php echo esc_attr($id_map); ?>')[0].getAttribute('data-lon');
                        var lat1= $('.ek-dr-from_<?php echo esc_attr($id_map); ?>')[0].getAttribute('data-lat');
                        var text2= $('.ek-dr-to_<?php echo esc_attr($id_map); ?>').val();
                        var lon2=$('.ek-dr-to_<?php echo esc_attr($id_map); ?>')[0].getAttribute('data-lon');
                        var lat2=$('.ek-dr-to_<?php echo esc_attr($id_map); ?>')[0].getAttribute('data-lat');
                        $('.ek-dr-from_<?php echo esc_attr($id_map); ?>').val(text2);
                        $('.ek-dr-from_<?php echo esc_attr($id_map); ?>')[0].setAttribute('data-lon',lon2);
                        $('.ek-dr-from_<?php echo esc_attr($id_map); ?>')[0].setAttribute('data-lat',lat2);
                        $('.ek-dr-to_<?php echo esc_attr($id_map); ?>').val(text1);
                        $('.ek-dr-to_<?php echo esc_attr($id_map); ?>')[0].setAttribute('data-lon',lon1);
                        $('.ek-dr-to_<?php echo esc_attr($id_map); ?>')[0].setAttribute('data-lat',lat1);
                        changeinput_<?php echo esc_attr($id_map); ?>();
                    });


                    $(document).on('click', '.ek-dr-close_<?php echo esc_attr($id_map); ?>',function(){
                        collapseSidebar_<?php echo esc_attr($id_map); ?>('ek-left_<?php echo esc_attr($id_map); ?>');
                        if (markerFrom_<?php echo esc_attr($id_map); ?>) markerFrom_<?php echo esc_attr($id_map); ?>.remove();
                        if (markerTo_<?php echo esc_attr($id_map); ?>) markerTo_<?php echo esc_attr($id_map); ?>.remove();
                        if (popupDr_<?php echo esc_attr($id_map); ?>) popupDr_<?php echo esc_attr($id_map); ?>.remove();
                        if (map_<?php echo esc_attr($id_map); ?>.getLayer('route')) map_<?php echo esc_attr($id_map); ?>.removeLayer('route');
                        if (map_<?php echo esc_attr($id_map); ?>.getSource('route')) map_<?php echo esc_attr($id_map); ?>.removeSource('route');
                        $('.ek-dr-from_<?php echo esc_attr($id_map); ?>')[0].value="";
                        $('.ek-dr-from_<?php echo esc_attr($id_map); ?>')[0].setAttribute('data-lon',"");
                        $('.ek-dr-from_<?php echo esc_attr($id_map); ?>')[0].setAttribute('data-lat',"");
                        $('.ek-dr-to_<?php echo esc_attr($id_map); ?>')[0].value="";
                        $('.ek-dr-to_<?php echo esc_attr($id_map); ?>')[0].setAttribute('data-lon',"");
                        $('.ek-dr-to_<?php echo esc_attr($id_map); ?>')[0].setAttribute('data-lat',"");
                        $('.ek-vehicle_<?php echo esc_attr($id_map); ?>').val('car');
                        let lat = '<?php echo esc_attr($lon_); ?>';
                        let lon = '<?php echo esc_attr($lat_); ?>';
                        map_<?php echo esc_attr($id_map); ?>.flyTo({
                            center: [lat,lon],
                            zoom: '<?php echo esc_attr($zoom_); ?>',
                            bearing:'<?php echo esc_attr($bearing_) ? : "0" ?>',
                            pitch:'<?php echo esc_attr($pitch_) ? : "0" ?>',
                        });
                        mapMarkers_open_<?php echo esc_attr($id_map); ?>.forEach((popup) => popup.removeClassName('ekmap-popup-hide'))
                    });

                    function RoutingbyGG_<?php echo esc_attr($id_map); ?>(lon,lat){
                        window.open("https://www.google.com/maps/dir//" + lat + "," + lon , "_blank");
                    }

                    function RoutingtoCurrentPosition_<?php echo esc_attr($id_map); ?>(lon,lat){
                        var startP, endP;
                        endP = [lon,lat].toString();
                        var param = {
                            'point.lon': lon,
                            'point.lat': lat,
                        };
                        geocoding.reverse(param, function (error, response) {
                            if (response.status == 'OK'){
                                $('.ek-dr-to_<?php echo esc_attr($id_map); ?>')[0].value = response.results[0].formatted_address;
                                $('.ek-dr-to_<?php echo esc_attr($id_map); ?>')[0].setAttribute('data-lon',response.results[0].geometry.location.lng);
                                $('.ek-dr-to_<?php echo esc_attr($id_map); ?>')[0].setAttribute('data-lat',response.results[0].geometry.location.lat);
                            }
                        });
                        if ($('.ek-dr-from_<?php echo esc_attr($id_map); ?>').val() != '') {
                            var startAdrs = $('.ek-dr-from_<?php echo esc_attr($id_map); ?>')[0];
                            startP = [startAdrs.getAttribute('data-lon'), startAdrs.getAttribute('data-lat')].toString();
                            setTimeout(routing_<?php echo esc_attr($id_map); ?>(startP, endP), 500)
                        } else if (currentPosition_<?php echo esc_attr($id_map); ?>.length == 0){
                            geolocate_<?php echo esc_attr($id_map); ?>.trigger();
                            geolocate_<?php echo esc_attr($id_map); ?>.on('geolocate', function(){
                                if( count_<?php echo esc_attr($id_map); ?> ==0){
                                    var paramRever = {
                                        'point.lon': currentPosition_<?php echo esc_attr($id_map); ?>[0],
                                        'point.lat': currentPosition_<?php echo esc_attr($id_map); ?>[1]
                                    }
                                    geocoding.reverse(paramRever, function (error, response) {
                                        if (response.status == 'OK'){
                                            $('.ek-dr-from_<?php echo esc_attr($id_map); ?>')[0].value = response.results[0].formatted_address;
                                            $('.ek-dr-from_<?php echo esc_attr($id_map); ?>')[0].setAttribute('data-lon',currentPosition_<?php echo esc_attr($id_map); ?>[0]);
                                            $('.ek-dr-from_<?php echo esc_attr($id_map); ?>')[0].setAttribute('data-lat',currentPosition_<?php echo esc_attr($id_map); ?>[1]);
                                            startP = currentPosition_<?php echo esc_attr($id_map); ?>.toString();
                                            routing_<?php echo esc_attr($id_map); ?>(startP, endP);
                                        }
                                    });
                                    count_<?php echo esc_attr($id_map); ?>++;
                                }
                            });
                            geolocate_<?php echo esc_attr($id_map); ?>.on('error', function(){
                                if(count_<?php echo esc_attr($id_map); ?> ==0 && $('.ek-dr-from_<?php echo esc_attr($id_map); ?>').val() == ''){
                                    alert('Điểm bắt đầu không được để trống.');
                                    count_<?php echo esc_attr($id_map); ?>++;
                                };
                            });
                        } else if (currentPosition_<?php echo esc_attr($id_map); ?>.length != 0){
                            var paramRever = {
                            'point.lon': currentPosition_<?php echo esc_attr($id_map); ?>[0],
                            'point.lat': currentPosition_<?php echo esc_attr($id_map); ?>[1]
                            };
                            geocoding.reverse(paramRever, function (error, response) {
                                if (response.status == 'OK'){
                                    $('.ek-dr-from_<?php echo esc_attr($id_map); ?>')[0].value = response.results[0].formatted_address;
                                    $('.ek-dr-from_<?php echo esc_attr($id_map); ?>')[0].setAttribute('data-lon',currentPosition_<?php echo esc_attr($id_map); ?>[0]);
                                    $('.ek-dr-from_<?php echo esc_attr($id_map); ?>')[0].setAttribute('data-lat',currentPosition_<?php echo esc_attr($id_map); ?>[1]);
                                    startP = currentPosition_<?php echo esc_attr($id_map); ?>.toString();
                                    routing_<?php echo esc_attr($id_map); ?>(startP, endP);
                                }
                            });
                        }
                        if(count_<?php echo esc_attr($id_map); ?> >0 && $('.ek-dr-from_<?php echo esc_attr($id_map); ?>').val() == '' && currentPosition_<?php echo esc_attr($id_map); ?>.length == 0){
                            alert('Điểm bắt đầu không được để trống.');
                        };
                    };

                    function changeinput_<?php echo esc_attr($id_map); ?>() {
                        var startPnt=[] ,endPnt =[];
                        var startAdrs = $('.ek-dr-from_<?php echo esc_attr($id_map); ?>')[0];
                        var endAdrs = $('.ek-dr-to_<?php echo esc_attr($id_map); ?>')[0];
                        if(startAdrs.value!="" && endAdrs.value!=""){
                            startPnt = [startAdrs.getAttribute('data-lon'), startAdrs.getAttribute('data-lat')].toString();
                            endPnt = [endAdrs.getAttribute('data-lon'), endAdrs.getAttribute('data-lat')].toString();
                            setTimeout(routing_<?php echo esc_attr($id_map); ?>(startPnt, endPnt), 500);
                        }
                    };

                    function routing_<?php echo esc_attr($id_map); ?>(startPoint, endPoint) {
                        if (startPoint != "," && endPoint != "," && startPoint != "" && endPoint != "" && startPoint != endPoint) {
                            var profile = $('.ek-vehicle_<?php echo esc_attr($id_map); ?>').val();
                            routingService.setProfile(profile);
                            var coordinates = startPoint + ";" + endPoint;
                            routingService.setCoordinates(coordinates);
                            var paramRoute = {
                                overview: "full",
                                alternatives: false,
                                steps: true,
                                geometries: "geojson",
                            };
                            mapMarkers_<?php echo esc_attr($id_map); ?>.forEach((marker) =>{
                                var popup = marker.getPopup();
                                if(popup.isOpen()) marker.togglePopup();
                            })
                            mapMarkers_open_<?php echo esc_attr($id_map); ?>.forEach((popup) => popup.addClassName('ekmap-popup-hide'))

                            routingService.getRoute(paramRoute, function (error, data) {
                                if (data.code == 'Ok') {
                                    let bbox = [startPoint.split(","), endPoint.split(",")];
                                    if(isMobileScreen_<?php echo esc_attr($id_map); ?>()){
                                        map_<?php echo esc_attr($id_map); ?>.fitBounds(bbox, {
                                            padding: { left: 100, right: 100, bottom:50, top:100 },
                                        });
                                    } else{
                                        map_<?php echo esc_attr($id_map); ?>.fitBounds(bbox, {
                                            padding: { left: 450,right:100, top: 50, bottom:100 },
                                        });
                                    }
                                    
                                    var featureData = {
                                        'type': 'Feature',
                                        'properties': {},
                                        'geometry': data.routes[0].geometry
                                    };
                                    if (map_<?php echo esc_attr($id_map); ?>.getSource('route')) {
                                        map_<?php echo esc_attr($id_map); ?>.getSource('route').setData(featureData);
                                    } else {
                                        map_<?php echo esc_attr($id_map); ?>.addSource('route', {
                                            'type': 'geojson',
                                            'data': featureData
                                        });
                                        map_<?php echo esc_attr($id_map); ?>.addLayer({
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
                                    let html = '';
                                    html += '<span style="width:100%; display:flex; line-height: initial;"><span class="ek-dr-icon ek-icon-marker"></span><span class="ek-dr-text">' + $('.ek-dr-from_<?php echo esc_attr($id_map); ?>')[0].value + '</span></span>';
                                    html += '<span style="width:100%; display:flex; margin-top: 3px;line-height: initial;"><span class="ek-dr-icon ek-icon-marker-home"></span><span class="ek-dr-text">' + $('.ek-dr-to_<?php echo esc_attr($id_map); ?>')[0].value + '</span></span>';
                                    html += '<span style="width:100%; display:flex; margin-top: 3px;"><span class="ek-dr-icon ek-icon-distance"></span><span class="ek-dr-text">' + format.duration(direction.duration) + '</span></span>';
                                    if (profile == 'car') html += '<span style="width:100%; display:flex; margin-top: 3px;"><span class="ek-dr-icon ek-icon-car"></span><span class="ek-dr-text">' + format['metric'](direction.distance) + '</span></span>';
                                    if (profile == 'bicycle') html += '<span style="width:100%; display:flex; margin-top: 3px;"><span class="ek-dr-icon ek-icon-bike"></span><span class="ek-dr-text">' + format['metric'](direction.distance) + '</span></span>';
                                    if (profile == 'foot') html += '<span style="width:100%; display:flex; margin-top: 3px;"><span class="ek-dr-icon ek-icon-foot"></span><span class="ek-dr-text">' + format['metric'](direction.distance) + '</span></span>';
                                    popupDr_<?php echo esc_attr($id_map); ?> = new maplibregl.Popup({focusAfterOpen:false, closeOnClick: false, offset: 25, className:"direct_popup_ekmap" }).setMaxWidth("300px").setHTML(html);
                                    if (markerFrom_<?php echo esc_attr($id_map); ?>) markerFrom_<?php echo esc_attr($id_map); ?>.remove();
                                    markerFrom_<?php echo esc_attr($id_map); ?> = new maplibregl.Marker()
                                        .setLngLat(startPoint.split(","))
                                        .addTo(map_<?php echo esc_attr($id_map); ?>);

                                    if (markerTo_<?php echo esc_attr($id_map); ?>) markerTo_<?php echo esc_attr($id_map); ?>.remove();
                                    markerTo_<?php echo esc_attr($id_map); ?> = new maplibregl.Marker({ color: 'red' })
                                        .setLngLat(endPoint.split(","))
                                        .setPopup(popupDr_<?php echo esc_attr($id_map); ?>)
                                        .addTo(map_<?php echo esc_attr($id_map); ?>);
                                    popupDr_<?php echo esc_attr($id_map); ?>.setLngLat(endPoint.split(",")).addTo(map_<?php echo esc_attr($id_map); ?>);
                                    expandSidebar_<?php echo esc_attr($id_map); ?>('ek-left_<?php echo esc_attr($id_map); ?>');
                                    showDirect_<?php echo esc_attr($id_map); ?>('ek-left_<?php echo esc_attr($id_map); ?>', direction);
                                }
                                else alert('Thông tin đường đi không khả dụng.')
                            })
                        }else{
                            collapseSidebar_<?php echo esc_attr($id_map); ?>('ek-left_<?php echo esc_attr($id_map); ?>');
                            if (markerFrom_<?php echo esc_attr($id_map); ?>) markerFrom_<?php echo esc_attr($id_map); ?>.remove();
                            if (markerTo_<?php echo esc_attr($id_map); ?>) markerTo_<?php echo esc_attr($id_map); ?>.remove();
                            if (popupDr_<?php echo esc_attr($id_map); ?>) popupDr_<?php echo esc_attr($id_map); ?>.remove();
                            if (map_<?php echo esc_attr($id_map); ?>.getLayer('route')) map_<?php echo esc_attr($id_map); ?>.removeLayer('route');
                            if (map_<?php echo esc_attr($id_map); ?>.getSource('route')) map_<?php echo esc_attr($id_map); ?>.removeSource('route');
                            alert('Thông tin đường đi không khả dụng.')
                        } 
                    };

                    function showDirect_<?php echo esc_attr($id_map); ?>(id,arr){
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

                        let html=``;
                        html +=`
                        <div class='ek-dr-h-text'>
                            <span>từ <strong>` + $('.ek-dr-from_<?php echo esc_attr($id_map); ?>').val() +`</strong></span>
                            <span>đến <strong>` + $('.ek-dr-to_<?php echo esc_attr($id_map); ?>').val() +`</strong></span>
                        </div>
                        <span class="ek-dr-cls-btn" title="Đóng"><span class="ek-icon-close ek-dr-close_<?php echo esc_attr($id_map); ?>"></span></span>`;
                        let headerDOM = document.getElementById(id).querySelector(".ek-dr-header");
                        headerDOM.innerHTML = html;

                        let tempHTML = '';
                        src.forEach(x => {
                            tempHTML += `
                            <div class='ek-step-details'>
                                <span class='ek-step-icon'><span class="${convertArrow(x)}"></span></span>
                                <div class='ek-step-info'>
                                    <div> ${convertName(x)}</div>
                                    <div>` + format['metric'](x.distance) +`</div>
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

                    function autocomplete_<?php echo esc_attr($id_map); ?>(inp) {
                        var currentFocus;
                        inp.addEventListener("input", function (e) {
                            var textSearch = inp.value;
                            var list=[];
                            var a, b, i, val = this.value;
                            var me=this;
                            if (textSearch!=""){
                                geocoding.autoComplete(textSearch, function(error, response){
                                    if (response.status == 'OK') list = response.results;
                                    else list = [];
                                    closeAllLists();
                                    if (!val) { return false; }
                                    currentFocus = -1;
                                    a = document.createElement("DIV");
                                    a.setAttribute("id",  inp.name + "-ek-autocomplete-list");
                                    a.setAttribute("class", "ek-autocomplete-items ekmap-scrollbar");
                                    a.setAttribute("style", "width:" + inp.offsetWidth + 'px');
                                    me.parentNode.appendChild(a);
                                    for (i = 0; i < list.length; i++) {
                                        b = document.createElement("DIV");
                                        b.innerHTML = list[i].formatted_address;
                                        b.innerHTML += "<input type='hidden' value='" + list[i].formatted_address + "' lon='"+list[i].geometry.location.lng+"' lat='"+list[i].geometry.location.lat+"'>";
                                        b.addEventListener("click", function (e) {
                                            inp.value = this.getElementsByTagName("input")[0].value;
                                            var lon =this.querySelector('input').getAttribute('lon');
                                            var lat =this.querySelector('input').getAttribute('lat');
                                            inp.setAttribute('data-lon',lon);
                                            inp.setAttribute('data-lat',lat);
                                            closeAllLists();
                                            setTimeout(changeinput_<?php echo esc_attr($id_map); ?>,300);
                                        });
                                        a.appendChild(b);
                                    }
                                })
                            }
                            
                        });
                        inp.addEventListener("keydown", function (e) {
                            var x = document.getElementById(inp.name + "-ek-autocomplete-list");
                            if (x) x = x.getElementsByTagName("div");
                            if (e.keyCode == 40) {
                                currentFocus++;
                                if (currentFocus >0 ) document.getElementById(inp.name + "-ek-autocomplete-list").scrollTop += 30;
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
                                setTimeout(changeinput_<?php echo esc_attr($id_map); ?>,300);
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

                    function collapseSidebar_<?php echo esc_attr($id_map); ?>(id) {
                        var elem = document.getElementById(id);
                        elem.classList.add('ek-collapsed');
                    }

                    function expandSidebar_<?php echo esc_attr($id_map); ?>(id) {
                        var elem = document.getElementById(id);
                        elem.classList.remove("ek-collapsed");
                    }

                    //ktra kích thước màn hình
                    function isMobileScreen_<?php echo esc_attr($id_map); ?>() {
                        var x = window.matchMedia("(max-width: 768px)");
                        if (x.matches) return true;
                        else return false;
                    }
                },100)

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
            }(jQuery) );
        </script>
        <?php
    },999999999);
    endif;
    return ob_get_clean();
});
?>
