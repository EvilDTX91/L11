<div class="row">
    <div class="col-md-12">
        <label for="SelectEpisodeName"><b>Epizód szűrő</b></label>
        <select class="form-select select2" id="SelectEpisodeName" name="SelectEpisodeName" onchange="SelectEpisodeName()">
            <option value="">Mind</option>
            @foreach ($EpisodeList as $episode)
                <option value="{{ $episode->name }}">{{ $episode->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-12">
        <label for="date-start-end"><b>Dátum szűrő</b></label>
        <div class="input-group mb-3">
            <input type="text" class="date form-control" id="date-start-end" name="date-start-end" value="">
            <div class="input-group-append">
                <span class="input-group-text p-3">
                    <label for="date-start-end">
                        <i class="fa fa-calendar-check"></i>
                    </label>
                </span>
            </div>
        </div>
    </div>
</div>
