<table id="RickAndMortyEpisodeListTable" class="table" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="th-sm">Epizód</th>
            <th class="th-sm">Cím</th>
            <th class="th-sm">Adásban</th>
            <th class="th-sm">Elkészült</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($EpisodeList as $episode)
            <tr onclick="GetEpisodeCharaterList({{ $episode->id }})">
                <td>
                    {{ $episode->episode }}
                </td>
                <td>
                    {{ $episode->name }}
                </td>
                <td>
                    {{ $episode->air_date }}
                </td>
                <td>
                    {{ $episode->created }}
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Epizód</th>
            <th>Cím</th>
            <th>Adásban</th>
            <th>Elkészült</th>
        </tr>
    </tfoot>
</table>
