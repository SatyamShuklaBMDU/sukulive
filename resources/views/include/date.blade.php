<div class="col-sm-1">
    <p class="text-dark mt-4">
        <b style="font-size: 15px;">
            Filter:
        </b>
    </p>
</div>
<div class="col-sm-2 end-date">
    {{-- <div class="d-inline-flex"> --}}
    {{-- <p class="text-dark px-1">
            <strong>Date From:</strong>
        </p> --}}
    {{-- <div class="input-group date d-flex"> --}}
    <label for="start_date"><strong>From:</strong></label>
    <input type="date" id="startdate" class="form-control @error('start') is-invalid @enderror" name="start"
        id="datepickerFrom" style="font-size: 15px;" value="{{ old('start', $start ?? '') }}" placeholder="dd-mm-yyyy">
    @error('start')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    {{-- </div>   --}}
    {{-- </div>                                   --}}
</div>
<div class="col-sm-2 end-date ms-4">
    {{-- <div class="d-inline-flex">

        <div class="input-group date d-flex"> --}}
    <label for="start_date"><strong>To:</strong></label>
    <input type="date" id="enddate" class="form-control @error('end') is-invalid @enderror" name="end"
        id="datepickerTo" style="font-size: 15px;" value="{{ old('end', $end ?? '') }}" placeholder="dd-mm-yyyy"
        style="width:55%">
    @error('end')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    {{-- </div>
    </div> --}}
</div>
<div class="col-sm-1 mt-4 ms-4" style="margin-top: 0px;">
    <button class="btn text-white shadow-lg" type="submit"
        style="background-color: #ff8196;font-size:15px;box-shadow: 2px 10px 9px 0px #00000063 !important">Filter</button>
</div>
