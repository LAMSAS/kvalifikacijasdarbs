<x-app-layout :aimx="$aimx">

    <div class="container">

        @include($aimx['module']. '::'. $aimx['code']. '_profile_header', ['aimx' => $aimx, 'tab' => $tab, 'team' => $team, 'allTeamTypes' => $allTeamTypes, 'allManagers' => $allManagers])

        @include($aimx['module']. '::'. $aimx['code']. '_profile_'.$tab , ['aimx' => $aimx, 'tab' => $tab, 'allTeamTypes' => $allTeamTypes, 'allManagers' => $allManagers])

    </div>

</x-app-layout>
