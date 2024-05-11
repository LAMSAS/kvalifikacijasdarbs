<x-app-layout :aimx="$aimx">

    <div class="container">

        @include($aimx['module']. '::'. $aimx['code']. '_create_header', ['aimx' => $aimx, 'tab' => $tab])

        @include($aimx['module']. '::'. $aimx['code']. '_create_'.$tab , ['aimx' => $aimx, 'tab' => $tab])
        
    </div>

</x-app-layout>
