<header>
    <div class="col10" style="align-items:center;line-height: 2px;">
        <div class="col2" style="text-align: center;border:">
            <img src="{{ public_path($data['setting']['company-logo'] ?? '/images/logo.png') }}" alt=""
                style="margin-top:0px;width:120px;height:80px" />
        </div>
        <div class="col6" style="text-align: center;padding-top:5px">
            <p style="font-size: 12px;font-weight:bold;">
                {{ $data['setting']['company-name'] ?? '' }}</p>
            <p style=""> Website: {{ $data['setting']['company-name'] ?? '' }} - Mst:
                {{ $data['setting']['company-tax'] ?? '' }} - Email: {{ $data['setting']['company-email'] ?? '' }}</p>
            <p style=""> Văn phòng: {{ $data['setting']['company-address'] ?? '' }}</p>
        </div>
        <div class="col2" style="text-align: center;align-items:center;padding-top:10px">
            <p>Hotline</p>
            <p style="color: red;font-size: 12px;font-weight:bold;">{{ $data['setting']['company-hotline'] ?? '' }}</p>
        </div>
    </div>
</header>
