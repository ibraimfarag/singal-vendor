@foreach($datas as $data)
    <tr>
        <td>
            {{ $data->name }}
        </td>
        <td>
            {{ $data->attribute }}
        </td>
        <td>
            {{ $data->price == 0 ? __('Free') : PriceHelper::adminCurrencyPrice($data->price) }}
        </td>
        <td>
            <div class="action-list">
                <a class="btn btn-secondary btn-sm "
                    href="{{ route('back.option.edit',[$item->id, $data->id]) }}">
                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                </a>
                <a class="btn btn-danger btn-sm " data-toggle="modal"
                    data-target="#confirm-delete" href="javascript:;"
                    data-href="{{ route('back.option.destroy',[$item->id, $data->id]) }}">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </div>
        </td>
    </tr>
@endforeach
