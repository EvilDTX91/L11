<table id="RickAndMortyEpisodeCharacterListTable" class="table" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="th-sm">Név</th>
            <th class="th-sm">Státusz</th>
            <th class="th-sm">Faj</th>
            <th class="th-sm">Nem</th>
            <th class="th-sm">Származás</th>
            <th class="th-sm">Lokáció</th>
            <th class="th-sm">Avatar</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($CharacterList as $character)
            <tr>
                <td>
                    {{ $character->characterData->name }}
                </td>
                <td>
                    {{ $character->characterData->status }}
                </td>
                <td>
                    {{ $character->characterData->species }}
                </td>
                <td>
                    {{ $character->characterData->gender }}
                </td>
                <td>
                    {{ $character->characterData->originData ? $character->characterData->originData->name : $character->characterData->origin }}
                </td>
                <td>
                    {{ $character->characterData->locationData ? $character->characterData->locationData->name : $character->characterData->origin }}
                </td>
                <td>
                    <a class="btn btn-sm btn-info text-white" href="{{ $character->characterData->image }}" target="_blank">Mutasd</a>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Név</th>
            <th>Státusz</th>
            <th>Faj</th>
            <th>Nem</th>
            <th>Származás</th>
            <th>Lokáció</th>
            <th>Avatar</th>
        </tr>
    </tfoot>
</table>
