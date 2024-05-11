<form data-request="onAction">
    <div class="row">
        <div class="col-md-8" id="employee-profile-overview-form">
            @include($aimx['module'].'::'.$aimx['code'].'_profile_overview_form', ['team' => $team])
        </div>
        <div class="col-md-4" id="employee-profile-overview-widgets">
            @include($aimx['module'].'::'.$aimx['code'].'_profile_overview_widgets')
        </div>
    </div>
</form>
