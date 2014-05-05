<div class="pPanel">
    <div class="onePanel" position="left">
        <pWindow
            class="pWindow" 
            pwtitle="{{params.pwindow.pwKpProperty.title}}" 
        >
            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.id}}:</label>
                <span class="val">{{kp.id}}</span>
            </div>
            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.name}}:</label>
                <span class="val"><input ng-model="kp.name" name="name" type="text"></span>
            </div>
            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.status}}:</label>
                <span class="val">
                    <select ng-model="kp.status" ng-options="c.value as c.label for c in params.status"></select>
                </span>
            </div>

            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.date_status}}:</label>
                <span class="val"><input ng-model="kp.date_status" name="date_status" type="datetime"></span>
            </div>
            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.date_finish}}:</label>
                <span class="val"><input ng-model="kp.date_finish" name="date_finish" type="datetime"></span>
            </div>

            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.u_id_create}}:</label>
                <span class="val">{{kp.u_id_create.surname}}</span>
            </div>
            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.date_create}}:</label>
                <span class="val">{{kp.date_create}}</span>
            </div>

            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.u_id_edit}}:</label>
                <span class="val">{{kp.u_id_edit.surname}}</span>
            </div>
            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.date_edit}}:</label>
                <span class="val">{{kp.date_edit}}</span>
            </div>

            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.auditor_id}}:</label>
                <span class="val">{{kp.auditor_id.surname}}</span>
            </div>
            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.auditor_status}}:</label>
                <span class="val">
                    <select ng-model="kp.auditor_status" ng-options="c.value as c.label for c in params.auditor_status"></select>
                </span>
            </div>
            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.auditor_date_status}}:</label>
                <span class="val">{{kp.auditor_date_status}}</span>
            </div>
            <div class="prop">
                <label class="key">{{params.pwindow.pwKpProperty.data.auditor_comment}}:</label>
                <span class="val"><textarea ng-model="kp.auditor_comment"></textarea></span>
            </div>
        </pWindow>
    </div>
    <div class="onePanel" position="center">
        {{kp.json}}
    </div>
    <div class="onePanel" position="right">
        <pWindow
            class="pWindow" 
            pwtitle="{{params.pwindow.itemCSS.title}}" 
            >esfwefw</pWindow>
    </div>
</div>