@foreach($datas as $data)
<tr>
    <td>
        {{ $data->language }}
    </td>
    <td>
        @if ($data->rtl == 0)
            {{__('LTR')}}
        @else
            {{__('RTL')}}
        @endif
    </td>

    <td>
        <div class="dropdown">
            <button class="btn btn-{{  $data->is_default == 1 ? 'success' : 'danger'  }} btn-sm  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{  $data->is_default == 1 ? __('Active') : __('Deactive')  }}
            </button>
            <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="{{ route('back.language.status',[$data->id,1]) }}">{{ __('Active') }}</a>
              <a class="dropdown-item" href="{{ route('back.language.status',[$data->id,0]) }}">{{ __('Deactive') }}</a>
            </div>
          </div>
    </td>
    <td>
        <div class="action-list">
            <a class="btn btn-secondary btn-sm "
                href="{{ route('back.language.edit',$data->id) }}">
                <i class="fas fa-edit"></i> {{ __('Edit') }}
            </a>

        </div>
    </td>
</tr>
@endforeach
