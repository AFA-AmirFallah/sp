@if (Auth::check())
    @if (Auth::user()->Role > 50)
        <div class="dialer-display">
            <span id="display-number"></span>
        </div>
        <div class="dialer-pad">
            <button class="keypad" onclick="addDigit('1')">1</button>
            <button class="keypad" onclick="addDigit('2')">2</button>
            <button class="keypad" onclick="addDigit('3')">3</button>
            <button class="keypad" onclick="addDigit('4')">4</button>
            <button class="keypad" onclick="addDigit('5')">5</button>
            <button class="keypad" onclick="addDigit('6')">6</button>
            <button class="keypad" onclick="addDigit('7')">7</button>
            <button class="keypad" onclick="addDigit('8')">8</button>
            <button class="keypad" onclick="addDigit('9')">9</button>
            <button class="keypad" onclick="addDigit('*')">*</button>
            <button class="keypad" onclick="addDigit('0')">0</button>
            <button class="keypad" onclick="addDigit('#')">#</button>
        </div>
        <div class="call-area">
            <div style="color: white;font-size:18px;" class="save-button" onclick="backToKeypad()">
                <i class="i-Left"></i>
            </div>
            <div style="color: white;font-size:18px;" class="call-button" onclick="makeCall()">
                <i class="i-Telephone"></i>
            </div>
            <div style="color: white;font-size:18px;" class="del-button" onclick="delete_dial()">
                <i class="i-Repeat"></i>
            </div>
        </div>
        <div class="phone-selector">
            <select class="form-control phone_selector" name="my_phone" id="my_phone">
                <option selected value="{{ Auth::user()->MobileNo }}">{{ Auth::user()->MobileNo }}</option>
                @if (Auth::user()->Phone1 != null)
                    <option value="{{ Auth::user()->Phone1 }}">{{ Auth::user()->Phone1 }}</option>
                @endif
                @if (Auth::user()->Phone2 != null)
                    <option value="{{ Auth::user()->Phone2 }}">{{ Auth::user()->Phone2 }}</option>
                @endif
            </select>
        </div>
    @endif
@endif
