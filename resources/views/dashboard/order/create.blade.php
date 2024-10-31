@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $title }}</h5>

            @include('layouts.partials.alert-message')

            <form class="mb-4" onsubmit="submitOrder(event)">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Pelanggan</label>
                            <br>
                            <select name="customer_id" id="customer_id" class="form-select">
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="mb-3">
                            <label for="order_date" class="form-label">Tanggal Transaksi</label>
                            <input type="date" class="form-control" id="order_date" name="order_date">
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="mb-3">
                        <label for="book_id" class="form-label">Buku</label>
                        <br>
                        <select name="book_id" id="book_id" class="form-select">
                        </select>
                    </div>
                </div>

                <button class="btn btn-primary">
                    <i class="fas fa-save fa-fw me-2"></i>
                    <span>Simpan</span>
                </button>
            </form>

            <table class="responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td width="5%">#</td>
                            <td>Judul</td>
                            <td>Penulis</td>
                            <td>Tahun</td>
                            <td>Harga</td>
                            <td>Jumlah</td>
                            <td>Subtotal</td>
                            <td>Action</td>
                        </tr>
                    </thead>

                    <tbody id="book-list">

                    </tbody>
                </table>
            </table>

        </div>
    </div>
@endsection

@push('js')
    <script>
        const customers = @json($customers);
        const books = @json($books);

        let bookList = [];

        function submitOrder(evet) {
            evet.preventDefault();
            const customer = $('#customer_id').val();
            const orderDate = $('#order_date').val();
            const details = bookList.map((list) => {
                return {
                    book_id: list.id,
                    quantity: list.quantity
                }
            });

            let formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('customer_id', customer);
            formData.append('order_date', orderDate);
            formData.append('details', JSON.stringify(details));

            $.ajax({
                type: "post",
                url: route('order.store'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    window.location = route('order.index');
                },
                error(xhr) {
                    alert('Terjadi kesalahan');
                }
            });
        }

        function deleteItem(index) {
            bookList.splice(index, 1);
            renderData();
        }

        function renderData() {
            $('#book-list').empty();
            bookList.forEach((book, index) => {
                $('#book-list').append(
                    `
                    <tr>
                            <td>${Number(index) + 1 }</td>
                            <td>${book.title }</td>
                            <td>${book.author }</td>
                            <td>${book.year }</td>
                            <td>${book.price }</td>
                            <td>${book.quantity }</td>
                            <td>${book.subtotal }</td>
                            <td>
                                <button type="button" onclick="deleteItem(${index})" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                    </tr>
                    `
                );
            });
        }

        $(document).ready(function() {
            $('#customer_id').select2({
                data: customers.map((customer) => {
                    return {
                        id: customer.customer_id,
                        text: customer.customer_name,
                        customer
                    }
                })
            });

            $('#book_id').select2({
                data: books.map((book) => {
                    return {
                        id: book.id,
                        text: book.title,
                        book
                    }
                })
            });

            $('#book_id').on('select2:select', function(e) {
                const data = e.params.data;
                const book = data.book;

                // Cari buku dalam bookList berdasarkan ID
                const existingBook = bookList.find(item => item.id === book.id);

                if (existingBook) {
                    // Jika sudah ada, update quantity dan subtotal
                    existingBook.quantity += 1;
                    existingBook.subtotal = existingBook.quantity * existingBook.price;
                } else {
                    // Jika belum ada, tambahkan sebagai item baru
                    bookList.push({
                        id: book.id,
                        title: book.title,
                        year: book.year,
                        author: book.author,
                        quantity: 1,
                        price: book.price,
                        subtotal: 1 * book.price
                    });
                }

                $('#book_id').val(null).trigger('change');
                renderData();
            });

        });
    </script>
@endpush
