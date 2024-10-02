<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        color-adjust: exact;
    }

    body {
        height: 100vh;
        display: grid;
        place-items: center;
    }

    .invoice {
        /*width: min(600px,90vw);*/
        width: 100%;
        font: 100 0.7rem 'myriad pro',helvetica,sans-serif;
        border: 0.5px solid black;
        padding: 4rem 3rem;
        display: flex;
        flex-direction: column;
        gap: 3rem;
    }

    .invoice-wrapper {
        display: flex;
        justify-content: space-between;
        padding: 0 1rem;
    }

    .invoice-company { text-align: right; }

    .invoice-company-name {
        font-size: 0.9rem;
        margin-bottom: 1.25rem;
    }

    .invoice-company-address {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .invoice-logo {
        width: 5rem;
        height: 5rem;
    }

    .invoice-billing-company {
        font-size: 0.65rem;
        margin-bottom: 0.25rem;
    }

    .invoice-billing-address {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .invoice-info {
        display: flex;
        justify-content: space-between;
        gap: 2rem;
        margin: 0.25rem 0;
    }

    .invoice-info:nth-of-type(5) { margin-top: 1.5rem; }
    .invoice-info-value { font-weight: 900; }
    .invoicetable { width: 100%; }
    .invoice-table, th, td { border-collapse: collapse; }

    th, td {
        width: calc((600px - 3rem) / 4);
        text-align: center;
        padding: 0.75rem;
    }

    tr:nth-of-type(1) { background-color: rgba(0,0,0,0.2); }
    tr:nth-of-type(2), tr:nth-of-type(3) { border-bottom: 0.5px solid rgba(0,0,0,0.25); }

    .invoice-total { font-weight: 900; }

    .invoice-print {
        font-size: 1.25rem;
        margin: 0 auto;
        cursor: pointer;
        border: 1.25px solid black;
        border-radius: 50%;
        padding: 0.6rem;
    }

    .invoice-print:active {
        background-color: black;
        color: white;
    }
    .invoice-logo {
        width: 19rem;
        height: 5rem;
    }
</style>
<main class='invoice'>
    <div class='invoice-wrapper'>
        <img src='https://lifragrances.com/portal/public/uploads/2191690604839.png' alt='logo' class='invoice-logo'>
        <div class='invoice-company'>
            <h2 class='invoice-company-name'>Long Island Fragrances</h2>
            <p class='invoice-company-address'>
                <span>9 N Fordham Rd</span>
                <span>Hicksville ,New York, 11801</span>
                <span>lifragrancesny@gmail.com</span>
                <span>5168141663</span>
            </p>
        </div>
    </div>
    <div class='invoice-wrapper'>
        <div class='invoice-billing'>
            <strong>{{$orders->first_name}} {{$orders->last_name}}</strong><br>
            {{$orders->address_1}}, {{$orders->address_2}},{{$orders->city}}, {{$orders->state}}, {{$orders->pincode}},  </span>
            <br><abbr title="Phone"> {{$orders->phone}}</abbr> <br>
            {{$orders->email}}
            <br>
            Shipping : {{$orders->selected_courier}}
        </div>
        <div class='invoice-details'>
            <div class='invoice-info'>
                <span class='invoice-info-key'>Invoice No:</span>
                <span class='invoice-info-value'>#{{$orders->order_id}}</span>
            </div>
            <div class='invoice-info'>
                <span class='invoice-info-key'>Client Number:</span>
                <span class='invoice-info-value'>{{$orders->phone}}</span>
            </div>
            <div class='invoice-info'>
                <span class='invoice-info-key'>Issue Date:</span>
                <span class='invoice-info-value'>{{$orders->created_at}}</span>
            </div>
        </div>
    </div>
    <table class="table table-hover c_table theme-color">
        <thead>
        <tr>
            <th>#</th>
            <th width="60px">Item</th>
            <th></th>
            <th class="hidden-sm-down">Size</th>
            <th>Quantity</th>
            <th class="hidden-sm-down">Unit Cost</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>

        @forelse($orders->get_order_products as $key =>  $products)
            <tr>
                <td>{{$key+1}}</td>
                <td><img src="{{asset($products->sizeAttributes[0]->image)}}" width="40" alt="Product img"></td>
                <td>{{$products->title}}</td>
                <td class="hidden-sm-down">{{$products->pivot->size}}</td>
                <td>{{$products->pivot->quantity}}</td>
                <td class="hidden-sm-down">{{$products->pivot->price}}</td>
                <td>{{$products->pivot->price * $products->pivot->quantity }}</td>
            </tr>
        @empty
        @endforelse
        </tbody>
    </table>
    <div class="row subtotal">
        <div class="col-md-6 text-right" style="text-align: right;">
{{--            <ul class="list-unstyled">--}}
{{--                <li><strong>Sub-Total:-</strong>$ {{number_format($orders->final_amount,2)}}</li>--}}
{{--            </ul>--}}

            <h2 class="mb-0 text-success" style="font-size:16px;" >Sales Tax : $ {{number_format($orders->sales_tax,2) ?? ''}}</h2>
            <h2 class="mb-0 text-success" style="font-size:16px;" >Shipping : {{$orders->shipping_price,2 ?? ''}}</h2>

            <h2 class="mb-0 text-success" style="font-size:24px;" >Final : $ {{number_format($orders->final_amount,2) ?? ''}}</h2>

        </div>
    </div>
    <a href="{{url('admin/view-orders/'.$orders->order_id)}}" style="text-align:center;">Back</a>
    <ion-icon name="print-outline" class='invoice-print'></ion-icon>
</main>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>
    const printButton = document.querySelector('.invoice-print');
    const media = window.matchMedia('print');

    const update = (e) => {
        if (e.matches) {
            // Hide the print button when printing
            printButton.style.display = 'none';
        } else {
            // Show the print button when not printing
            printButton.style.display = 'block';
        }
    };

    function convert() {
        // Add a listener for changes in print media
        media.addEventListener('change', update, false);

        // Trigger the print dialog
        window.print();

        // Redirect to the previous page after printing
        window.onafterprint = function () {
            history.back(); // Redirect to the previous page
        };
    }

    // Add a click event listener to the print button
    printButton.addEventListener('click', convert, false);
</script>

