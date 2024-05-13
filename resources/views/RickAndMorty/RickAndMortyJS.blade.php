<script>
    $(document).ready(function() {
        $(".select2").select2();

        AddRangedDateTimeFilterToDataTable('RickAndMortyEpisodeListTable');

        /**
         * Adattábla
         */
        var datatable = InitDataTable('RickAndMortyEpisodeListTable');

        var state = datatable.state.loaded();
        if (state) {
            var name = state.columns[1].search.search;
            SelectEpisodeName(name, 0);
        }

        /**
         * Ha a dátum mező egy input és 'ranged' kezdő és végpont megadós
         */
        $('#date-start-end').on('change', function() {
            datatable.draw();
        });
    });

    /**
     * A epizód kiválasztó egyedi szűrő
     * @param {*} name #Epziód neve
     * @param {*} redraw #Datatable újra rajzolás
     */
    function SelectEpisodeName(name = '', redraw = 1) {
        $('#EpisodeNameFilter').val(name);
        if (redraw == 1) {
            var event = new Event('change');
            element = document.getElementById('EpisodeNameFilter');
            element.value = $("#SelectEpisodeName").val();
            element.dispatchEvent(event);
        }
    }

    /**
     * Egy felugró albakban megjeleníti az epizód szereplőit
     */
    function GetEpisodeCharaterList(episode) {
        $.ajax({
            type: "POST",
            url: "/rickandmorty/episode/characters",
            data: {
                _token: "{{ csrf_token() }}",
                episode
            },
            success: function(response) {
                Swal.fire({
                    title: 'Epizód szereplői',
                    html: response.html,
                    width: '90%',
                    showCloseButton: true,
                    confirmButtonText: 'Bezár',
                    didOpen: () => {
                        $('#RickAndMortyEpisodeCharacterListTable').DataTable({
                            responsive: true,
                            searching: true,
                            ordering: true,
                            language: {
                                url: "{{ asset('js/dataTables.hungarian.json') }}"
                            },
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                });
            }
        });
    }

    /**
     * Adatszinkron elindítás meghívása
     */
    function StartSync() {
        HideButtons()
        $.ajax({
            type: "POST",
            url: "/rickandmorty/init",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                Swal.fire({
                    title: 'Sikere',
                    text: response.message,
                    icon: 'success',
                    showCloseButton: true,
                    confirmButtonText: 'Rendben',
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    location.reload();
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Hiba',
                    text: xhr.responseJSON.errormessage,
                    icon: 'error',
                    showCloseButton: true,
                    confirmButtonText: 'Rendben',
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    location.reload();
                });
            }
        });
    }

    /**
     * Adatbázis tisztítás meghívása
     */
    function CleanDatabase() {
        Swal.fire({
            title: 'Rick és Morty adatbázis ürítése',
            text: "Biztosan üríti az adatbázist? Ez nem vissza vonható!",
            icon: 'question',
            showCloseButton: true,
            confirmButtonText: 'Rendben',
            cancelButtonText: 'Mégse',
            showCancelButton: true,
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                ClearDatabase();
            }
        });
    }

    /**
     * Adatbázis tisztítás
     */
    function ClearDatabase() {
        HideButtons()
        $.ajax({
            type: "POST",
            url: "/rickandmorty/database/clear",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                Swal.fire({
                    title: 'Sikere',
                    text: response.message,
                    icon: 'success',
                    showCloseButton: true,
                    confirmButtonText: 'Rendben',
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    window.location.href = '/rickandmorty';
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Hiba',
                    text: xhr.responseJSON.errormessage,
                    icon: 'error',
                    showCloseButton: true,
                    confirmButtonText: 'Rendben',
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    location.reload();
                });
            }
        });
    }

    /**
     * Dátum alapján történő szűrés
     * @param {*} tableid #HTML table id
     */
    function AddRangedDateTimeFilterToDataTable(tableid = 'RickAndMortyEpisodeListTable') {
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                /**
                 * Csak az adott táblát szűrjük mást nem
                 */
                if (settings.nTable.id !== tableid) {
                    return true;
                }
                /**
                 * Ha a dátum mező egy input és 'ranged' kezdő és végpont megadós
                 */
                var date_text = $('#date-start-end').val();
                var date_array = date_text.split(" to ");

                /**
                 * Vége dátum beállítás ha nincs megadva feltétel
                 */
                var d = new Date();
                var month = d.getMonth() + 1;
                var day = d.getDate();
                var today = d.getFullYear() + '-' +
                    (('' + month).length < 2 ? '0' : '') + month + '-' +
                    (('' + day).length < 2 ? '0' : '') + day;

                /**
                 * Ha üres a "min" akkor az összes a mai napig megjelenik
                 * Ha nem üres a "min" de üres a max akkor csak aznapiak kellenek
                 * Ha nem üres a "min" és a "max" sem akkor a két dátum közöttiek kellenek
                 */
                var min = date_array[0] === '' ? '1970-01-01 00:00:00' : date_array[0] + " 00:00:00";
                var max = date_array[0] === '' ? today + " 23:59:59" : (date_array[1] === undefined ?
                    date_array[0] + " 23:59:59" : date_array[1] + " 23:59:59");

                /**
                 * Ez a szűrendő oszlopot jeleöli
                 */
                var date = data[3];

                /**
                 * Szűrés
                 */
                if (
                    (min === null && max === null) ||
                    (min === null && date <= max) ||
                    (min <= date && max === null) ||
                    (min <= date && date <= max)
                ) {
                    return true;
                }
                return false;
            }
        );

        flatpickr(".date", {
            dateFormat: "Y-m-d",
            mode: "range" //csak ha egy mezős
        });
    }

    /**
     * Datatable plugin init
     * @param {*} tableid #HTML table id
     */
    function InitDataTable(tableid = 'RickAndMortyEpisodeListTable') {
        var datatable = $('#RickAndMortyEpisodeListTable').DataTable({
            responsive: true,
            searching: true,
            ordering: true,
            language: {
                url: "{{ asset('js/dataTables.hungarian.json') }}"
            },
            initComplete: function() {
                this.api()
                    .columns(1)
                    .every(function() {
                        var table = this;
                        var select = $(
                                '<select class="d-none" id="EpisodeNameFilter"><option value="">Mind</option></select>'
                            )
                            .appendTo(
                                table.column(1).header()
                            )
                            .on('change', function() {
                                table
                                    .column(1)

                                    .search($(this).val())
                                    .draw();
                            })
                            .on('click', function(e) {
                                e.stopPropagation();
                            });

                        table
                            .column(1)
                            .cache('search')
                            .sort()
                            .unique()
                            .each(function(d) {
                                select.append($('<option value="' + d + '">' + d +
                                    '</option>'));
                            });
                    });
            }
        });

        return datatable;
    }

    /**
     * Gombok elrejtés és spinner megjelenítése
     */
    function HideButtons() {
        $(".rambutton").prop("disabled", true);
        $(".rambutton").addClass("d-none");
        $(".rambuttonstatus").removeClass("d-none");
    }
</script>
