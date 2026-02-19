<div class="form-container">
    <div class="form-header">
        <div class="form-tabs">
            <ul>
                <li class="tab active" data-tab="general">General</li>
            </ul>
        </div>
        <div class="form-buttons">
            <ul>
                <li class="reset-button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>broom</title><path d="M19.36,2.72L20.78,4.14L15.06,9.85C16.13,11.39 16.28,13.24 15.38,14.44L9.06,8.12C10.26,7.22 12.11,7.37 13.65,8.44L19.36,2.72M5.93,17.57C3.92,15.56 2.69,13.16 2.35,10.92L7.23,8.83L14.67,16.27L12.58,21.15C10.34,20.81 7.94,19.58 5.93,17.57Z" /></svg>
                </li>
                <li class="store-button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>content-save</title><path d="M15,9H5V5H15M12,19A3,3 0 0,1 9,16A3,3 0 0,1 12,13A3,3 0 0,1 15,16A3,3 0 0,1 12,19M17,3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V7L17,3Z" /></svg>
                </li>
            </ul>
        </div>
    </div>
    <div class="form-body">
        <div class="validation-errors">
            <ul></ul>
        </div>

        <form>
            <div class="tab-content active" data-tab="general">
                <input name="id" type="hidden" value="{{ $record->id }}">
                <div class="form-element">
                    <div class="form-element-label">
                        <label>Nombre</label>                
                    </div>
                    <div class="form-element-input">
                        <input type="text" name="name" value="{{ $record->name }}">
                    </div>
                </div>
                <div class="form-element">
                    <div class="form-element-label">
                        <label>Email</label>                
                    </div>
                    <div class="form-element-input">
                        <input type="email" name="email" value="{{ $record->email }}">
                    </div>
                </div>
                <div class="form-element">
                    <div class="form-element-label">
                        <label>Contraseña</label>                
                    </div>
                    <div class="form-element-input">
                        <input type="password" name="password">
                    </div>
                </div>
                <div class="form-element">
                    <div class="form-element-label">
                        <label>Confirmar contraseña</label>                
                    </div>
                    <div class="form-element-input">
                        <input type="password" name="password_confirmation">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>