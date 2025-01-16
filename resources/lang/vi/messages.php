<?php

return [
    'error-internal-server' => 'Có lỗi gì đó đã xảy ra! Vui lòng thử lại sau.',
    'error-not-found' => 'Không tìm thấy bản ghi.',
    'error-error-system' => 'Lỗi hệ thống',
    'created-success' => 'Tạo thành công',
    'delete-success' => 'Xóa thành công',
    'update-success' => 'Cập nhật thành công',
    'restore-success' => 'Khôi phục thành công',
    'error-required' => 'Trường này là bắt buộc',
    'error-value' => 'Các giá trị phải là một mảng',
    'invalid-value' => 'Đối số không hợp lệ',
    'forbidden' => 'Hành động này bị cấm',
    'error-delete-attribute-variations' => 'Giá trị này đã được thêm vào sản phẩm.Hãy xóa các biến thể sản phẩm trước!',
    'error-anunexpected' => 'Đã xảy ra lỗi không mong muốn',
    'auth' => [
        'banned' => 'Tài khoản này đã bị khóa.Vui lòng thử lại sau.'
    ],
    'review' => [
        'error-review-forbidden' => 'Bạn chỉ có thể đánh giá một sản phẩm sau khi mua và chỉ một lần cho mỗi sản phẩm.',
    ],
    'product' => [
        'error-variant' => 'Biến thể bị sai định dạng.',
        'error-create.variant' => 'Không thể tạo biến thể',
        'error-failed-create.variant' => 'Tạo biến thể không thành công',
        'error-not-attribute' => 'Không thể tìm thấy giá trị thuộc tính',
        'error-not-create' => 'Không thể tạo sản phẩm',
        'error-varian-value' => 'Một số biến thể sẽ không được khởi tạo do thuộc tính không tồn tại',
        'error' => 'Có lỗi xảy ra!Hãy thử tạo lại sản phẩm',
        'error-not-product' => 'Không tìm thấy sản phẩm',
        'error-varian-empty' => 'Một số biến thể không thể tìm thấy thuộc tính nên sẽ không được khởi tạo',
        'error-update-product' => 'Không thể cập nhật sản phẩm',
        'error-variation' => 'Không có sẵn lúc này.'
    ],
    'post' => [
        'error-already-exists' => 'Tiêu đề hoặc slug đã tồn tại. Vui lòng chọn giá trị khác.',
        'error-Could-not-found-post' => 'Không thể tìm thấy bài viết',
        'error-delete-post' => 'Đã xảy ra lỗi khi xóa bài viết.',
        'error-restoring-post' => 'Đã xảy ra lỗi khi khôi phục bài viết.',
    ],
    'image' => [
        'error-image' => 'Không thể tạo hình ảnh. Có thể hình ảnh đang ở sai định dạng!',
        'error-can-not-image' => 'Không thể tìm thấy hình ảnh nào',
        'error-no-image' => 'Không có hình ảnh nào được tải lên',
    ],
    'group' => [
        'error-group' => 'Nhóm với tên này đã tồn tại.',
    ],
    'attribute' => [
        'error-can-not-attribute' => 'Không thể tìm thấy hình ảnh nào',
        'error-value-exists' => 'Đã tồn tại giá trị',
        'error-valid' => 'Không hợp lệ',
        'error-initialized' => 'Đã có lỗi xảy ra!Các giá trị sẽ không được khởi tạo',
    ],
    'sale' => [
        'error-can-not-sale' => 'Không thể tạo chương trình khuyến mãi',
        'error-invalid-type' => 'Loại không hợp lệ.',
        'error-invalid-value' => 'Giá trị không hợp lệ.',
    ],
    'order' => [
        'error-order' => 'Không có quyền',
        'error-provider-detail' => 'Vui lòng cung cấp thêm chi tiết.',
        'error-cancelled-order' => 'Đơn hàng đã được hủy thành công!',
        'error-payment' => 'Trạng thái thanh toán đã được cập nhật thành công',
        'error-specific' => 'Vui lòng cung cấp lý do cụ thể.',
        'error-confirmed' => 'Quản trị viên đã xác nhận đơn hàng',
        'error-delivered' => 'Đơn hàng đang được giao',
        'error-was-delivered' => 'Đơn hàng đã được giao',
        'error-processing' => 'Đơn hàng trả lại đang được xử lý',
        'error-returned-processing' => 'Đơn hàng đã được trả lại và đang được xử lý',
        'error-returned' => 'Đơn hàng đã được trả lại',
        'error-can-not-order' => 'Không thể hủy đơn hàng',
        'cant-cancel' => 'Đơn hàng đã được thanh toán không thể hủy',
        'cant-delete' => 'Bạn không thể xóa đơn hàng này.'
    ],
    'voucher' => [
        'error-voucher' => 'Voucher đã hết lượt sử dụng',
        'invalid-voucher' => 'Mã voucher không hợp lệ',
        'voucher-expired' => 'Voucher đã hết hạn',
        'number-expired' => 'Số lượt sử dụng voucher đã hết',
        'used' => 'Bạn đã sử dụng voucher này',
        'already-exists' => 'Mã voucher đã tồn tại',
        'cant-create' => 'Không thể tạo mới voucher',
        'error-update' => 'Cập nhật không thành công',
        'error-soft-deleted' => 'Xoá tạm thời thành công',
        'voucher-not-found' => 'Không tìm thấy voucher',
        'error-restore' => 'Khôi phục thành công',
        'error-force-deleted' => 'Xóa vĩnh viễn thành công',
    ],
    'topic' => [
        'error-can-not' => 'Không thể tìm thấy chủ đề',
        'error-restore' => 'Không thể khôi phục chủ đề',
        'error-force-delete' => 'Không thể xóa vĩnh viễn',
    ],
    'user' => [
        'error-user' => 'Không có quyền',
        'error-email' => 'Email này đã được sử dụng',
        'error-invalid' => 'Mã xác minh không hợp lệ',
        'error-register' => 'Đăng ký không thành công',
        'error-password' => 'Bạn đã nhập sai mật khẩu quá nhiều lần, vui lòng thử lại sau 5 phút',
        'error-wrong-password' => 'Sai mật khẩu',
        'error-current-password' => 'Mật khẩu hiện tại không đúng',
        'error-can-not-email' => 'Email không được tìm thấy trong hệ thống!',
        'error-wrong-verification' => 'Mã xác minh sai',
        'error-could-not-create' => 'Không thể tạo người dùng',
        'error-system' => 'Lỗi hệ thống!',
        'error-check-password' => 'Vui lòng kiểm tra lại mật khẩu của bạn!',
        'error-logout' => 'Đăng xuất thành công',
        'error-password-success' => 'Mật khẩu đã được thay đổi thành công',
        'error-email-not-found' => 'Không tìm thấy email!',
        'error-code' => 'Mã đã được gửi đến email của bạn!',
        'error-password-reset' => 'Mật khẩu đã được đặt lại thành công!',
        'error-add-favorite' => 'Đã thêm sản phẩm yêu thích thành công!',
        'error-profile' => 'Thông tin hồ sơ đã được cập nhật thành công!',
        'error-upload' => 'Không thể tìm thấy tệp nào để tải lên',
        'error-account' => 'Không tìm thấy tài khoản',
        'error-login' => 'Bạn chưa đăng nhập',
        'error-avatar' => 'Không thể cập nhật ảnh đại diện',
    ],
    'mail' => [
        'order-success' => [
            'invoice' => 'Hóa Đơn',
            'created' => 'Ngày tạo',
            'status' => 'Trạng Thái',
            'status_order' => [
                'cancelled' => 'Đã Hủy',
                'waiting_confirm' => 'Chờ Xác Nhận',
                'confirmed' => 'Đã Xác Nhận',
                'delivering' => 'Đang Giao',
                'delivered' => 'Đã Giao',
                'waiting_payment' => 'Chờ Thanh Toán',
                'waiting_accept_return' => 'Chờ Chấp Nhận Trả Hàng',
                'return_processing' => 'Đang Trong Quá Trình Trả Hàng',
                'denied_return' => 'Từ Chối Trả Hàng',
                'returned' => 'Đã Trả'
            ],
            'payment_method_title' => 'Phương Thức Thanh Toán ',
            'payment_method' => [
                'banking' => 'Chuyển Khoản',
                'momo' => 'Cổng Thanh Toán Momo',
                'vnpay' => 'Cổng Thanh Toán VnPay',
                'cash_on_delivery' => 'Thanh Toán Khi Nhận Hàng',
            ],
            'item_text' => 'Sản Phẩm',
            'price_text' => 'Giá',
            'subtotal_text' => 'Tổng Phụ',
            'delivery_fee' => 'Phí Vận Chuyển',
            'total_text' => 'Tổng',
            'create_message_title' => 'Cảm ơn đã mua hàng!'
        ],
        'authentication-code' => [
            'title' => 'Mã Xác Thực Tài Khoản Fshoes Của Bạn',
            'span_code' => 'Đây là mã xác minh một lần mà bạn đã yêu cầu',
            'message_time' => 'Mã này sẽ có hiệu lực trong 5 phút',
            'message_ignore' => 'Nếu bạn đã nhận được mã này hoặc không cần nó nữa, hãy bỏ qua email này',
        ],
        'paid-order' => [
            'title' => 'Đơn Hàng Đã Thanh Toán Thành Công',
            'message_success' => 'Cảm ơn bạn đã thanh toán thành công đơn hàng của bạn. Chúng tôi sẽ tiến hành giao hàng cho bạn ngay khi đã xác nhận đơn hàng.',
            'link_text' => 'Xem ngay đơn hàng'
        ]
    ],
    'cart' => [
        'error-cart' => 'Không được phép truy cập.',
        'error-cart-add' => 'Không thể thêm giỏ hàng mới.',
        'error-quantity' => 'Không đủ số lượng.',
        'error-delete-cart' => 'Không thể xóa giỏ hàng.',
        'product_word' => 'Sản phẩm',
        'variations_word' => 'Biến thể',
        'out_of_stock' => ' đã hết hàng. Chỉ còn ',
        'units' => ' đơn vị',
        'error-stock' => 'Sản phẩm đã hết hàng',
        'error-not-found' => 'Không tìm thấy sản phẩm',
    ],
    'statiscs' => [
        'error-statiscs' => 'Lỗi hệ thống!',
    ],
    'update_review_request' => [
        'title' => [
            'sometimes.required' => 'Tiêu đề sản phẩm là bắt buộc nếu có.',
            'string' => 'Tiêu đề sản phẩm phải là một chuỗi.',
            'max' => 'Tiêu đề sản phẩm quá dài; tối đa là 255 ký tự.',
        ],
        'text' => [
            'sometimes.required' => 'Nội dung đánh giá là bắt buộc nếu có.',
            'string' => 'Nội dung đánh giá phải là một chuỗi.',
        ],
        'rating' => [
            'sometimes.required' => 'Đánh giá là bắt buộc nếu có.',
            'integer' => 'Đánh giá phải là một số nguyên.',
            'min' => 'Đánh giá phải ít nhất là 1.',
            'max' => 'Đánh giá không thể lớn hơn 5.',
        ],
    ],
    'create_review_request' => [
        'product_id' => [
            'required' => 'Mã sản phẩm là bắt buộc.',
            'exists' => 'Sản phẩm được chọn không tồn tại trong hệ thống.',
        ],
        'title' => [
            'required' => 'Tiêu đề là bắt buộc.',
            'string' => 'Tiêu đề phải là một chuỗi.',
            'max' => 'Tiêu đề không được vượt quá 255 ký tự.',
        ],
        'text' => [
            'required' => 'Nội dung đánh giá là bắt buộc.',
            'string' => 'Nội dung đánh giá phải là một chuỗi.',
        ],
        'rating' => [
            'required' => 'Đánh giá là bắt buộc.',
            'integer' => 'Đánh giá phải là một số nguyên.',
            'min' => 'Đánh giá phải ít nhất là 1.',
            'max' => 'Đánh giá không thể lớn hơn 5.',
        ],
    ],
    'create_voucher_request' => [
        'code' => [
            'required' => 'Mã giảm giá là bắt buộc.',
            'unique' => 'Mã giảm giá đã tồn tại.'
        ],
        'discount' => [
            'required' => 'Chiết khấu là bắt buộc.',
            'max' => 'Giá trị quá lớn hãy chọn lại'
        ],
        'date_start' => [
            'required' => 'Ngày bắt đầu là bắt buộc.',
        ],
        'date_end' => [
            'required' => 'Ngày kết thúc là bắt buộc.',
        ],
        'quantity' => [
            'required' => 'Số lượng là bắt buộc.',
            'max' => 'Số lượng quá lớn hãy chọn lại'
        ],
        'status' => [
            'required' => 'Trạng thái là bắt buộc.',
        ],
    ],

    'create_user_request' => [
        'name' => [
            'required' => 'Tên người dùng là bắt buộc.',
            'string' => 'Tên người dùng phải là một chuỗi ký tự.',
            'max' => 'Tên người dùng quá dài, tối đa là 255 ký tự.',

        ],
        'email' => [
            'required' => 'Email là bắt buộc.',
            'string' => 'Email phải là một chuỗi ký tự.',
            'max' => 'Email quá dài, tối đa là 255 ký tự.',
            'unique' => 'Email đã tồn tại.',
            'email' => 'Email không hợp lệ'
        ],
        'password' => [
            'required' => 'Mật khẩu là bắt buộc.',
            'string' => 'Mật khẩu phải là một chuỗi ký tự.',
            'min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ],
        'groups' => [
            'exists' => 'Nhóm không tồn tại.',
            'nullable' => 'Nhóm là tùy chọn.',
            'integer' => 'Nhóm phải là một số nguyên.',
        ],
        'profile' => [
            'birth_date' => [
                'date_format' => 'Ngày sinh sai định dạng',
                'invalid' => 'Ngày sinh không hợp lệ'
            ],
            'array' => 'Hồ sơ phải là một mảng.',
        ],
        'verify_code' => [
            'string' => 'Mã xác minh phải là một chuỗi ký tự.',
        ],
    ],

    'update_user_request' => [
        'name' => [
            'required' => 'Tên người dùng là bắt buộc.',
            'string' => 'Tên người dùng phải là một chuỗi ký tự.',
            'max' => 'Tên người dùng quá dài, tối đa là 255 ký tự.',
        ],
        'password' => [
            'required' => 'Mật khẩu là bắt buộc.',
            'string' => 'Mật khẩu phải là một chuỗi ký tự.',
            'min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ],
        'group' => [
            'exists' => 'Nhóm không tồn tại.',
            'nullable' => 'Nhóm là tùy chọn.',
            'integer' => 'Nhóm phải là một số nguyên.',
        ],
        'profile' => [
            'nullable' => 'Hồ sơ là tùy chọn.',
            'array' => 'Hồ sơ phải là một mảng.',
        ],
    ],

    'create_sale_request' => [
        'name' => [
            'required' => 'Tên đợt giảm giá là bắt buộc.',
            'string' => 'Tên chương trình giảm giá phải là một chuỗi ký tự.',
            'unique' => 'Tên đợt giảm giá đã tồn tại.Hãy thử một tên khác'
        ],
        'type' => [
            'in' => 'Loại giảm giá phải là "cố định" hoặc "phần trăm".',
        ],
        'value' => [
            'number' => 'Giá trị giảm giá phải là một số.',
            'max' => 'Giá trị quá lớn hãy nhập lại'
        ],
        'start_date' => [
            'date' => 'Ngày bắt đầu giảm giá phải là một ngày hợp lệ.',
            'before' => 'Ngày bắt đầu giảm giá không được sau ngày kết thúc.',
            'after' => 'Ngày bắt đầu giảm giá không được trước ngày hiện tại.'
        ],
        'is_active' => [
            'nullable' => 'Trường trạng thái hoạt động là tùy chọn.',
            'boolean' => 'Trường trạng thái hoạt động phải là đúng hoặc sai.',
        ],
        'end_date' => [
            'required' => 'Ngày kết thúc là bắt buộc.',
            'date_format' => 'Ngày kết thúc phải đúng định dạng.',
            'after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ],
        'products' => [
            'nullable' => 'Trường sản phẩm là tùy chọn.',
            'array' => 'Trường sản phẩm phải là một mảng.',
        ],
        'variations' => [
            'nullable' => 'Trường biến thể là tùy chọn.',
            'array' => 'Trường biến thể phải là một mảng.',
        ],
        'applyAll' => [
            'nullable' => 'Trường áp dụng tất cả là tùy chọn.',
            'boolean' => 'Trường áp dụng tất cả phải là đúng hoặc sai.',
        ],
    ],

    'update_sale_request' => [
        'name' => [
            'string' => 'Tên chương trình giảm giá phải là một chuỗi ký tự.',
        ],
        'type' => [
            'in' => 'Loại giảm giá phải là "cố định" hoặc "phần trăm".',
        ],
        'value' => [
            'number' => 'Giá trị giảm giá phải là một số.',
        ],
        'start_date' => [
            'date' => 'Ngày bắt đầu giảm giá phải là một ngày hợp lệ.',
            'before' => 'Ngày bắt đầu giảm giá không được sau ngày kết thúc.',
            'date_format' => 'Định dạng ngày không hợp lệ.',
            'required' => 'Ngày bắt đầu là bắt buộc.',
        ],
        'end_date' => [
            'after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
            'format' => 'Ngày kết thúc phải đúng định dạng.',
            'required' => 'Ngày kết thúc là bắt buộc.',
        ],
        'variations' => [
            'nullable' => 'Trường biến thể là tùy chọn.',
            'array' => 'Trường biến thể phải là một mảng.',
        ],
    ],

    'create_variation_request' => [
        'variations' => [
            'array' => 'Trường biến thể phải là một mảng.',
            '.*.price' => [
                'required' => 'Giá sản phẩm là bắt buộc.',
            ],
            '.*.stock_qty' => [
                'required' => 'Số lượng tồn kho của sản phẩm là bắt buộc.',
                'numeric' => 'Số lượng tồn kho của sản phẩm phải là một số.',
            ],
            '.*.import_price' => [
                'nullable' => 'Giá nhập khẩu của từng biến thể là tùy chọn.',
            ],
            '.*.sku' => [
                'nullable' => 'Mã SKU của từng biến thể là tùy chọn.',
                'string' => 'Mã SKU của từng biến thể phải là một chuỗi ký tự.',
            ],
            '.*.description' => [
                'nullable' => 'Mô tả của từng biến thể là tùy chọn.',
            ],
            '.*.short_description' => [
                'nullable' => 'Mô tả ngắn của từng biến thể là tùy chọn.',
            ],
            '.*.status' => [
                'nullable' => 'Trạng thái của từng biến thể là tùy chọn.',
            ],
            '.*.attributes' => [
                'array' => 'Thuộc tính của từng biến thể phải là một mảng.',
            ],
            '.*.images' => [
                'nullable' => 'Hình ảnh của từng biến thể là tùy chọn.',
                'array' => 'Hình ảnh của từng biến thể phải là một mảng.',
            ],
            '.*.values' => [
                'required' => 'Giá trị của từng biến thể là bắt buộc.',
                'array' => 'Giá trị của từng biến thể phải là một mảng.',
            ],
        ],
    ],

    'update_variation_request' => [
        'price' => [
            'required' => 'Giá biến thể là bắt buộc.',
        ],
        'stock_qty' => [
            'required' => 'Số lượng tồn kho của biến thể là bắt buộc.',
            'numeric' => 'Số lượng tồn kho của biến thể phải là một số.',
        ],
        'sku' => [
            'nullable' => 'Mã SKU là tùy chọn.',
            'string' => 'Mã SKU phải là một chuỗi ký tự.',
        ],
        'description' => [
            'nullable' => 'Mô tả là tùy chọn.',
        ],
        'short_description' => [
            'nullable' => 'Mô tả ngắn là tùy chọn.',
        ],
        'status' => [
            'nullable' => 'Trạng thái là tùy chọn.',
        ],
        'attributes' => [
            'array' => 'Thuộc tính phải là một mảng.',
        ],
        'images' => [
            'nullable' => 'Trường hình ảnh là tùy chọn.',
            'array' => 'Trường hình ảnh phải là một mảng.',
        ],
        'values' => [
            'required' => 'Trường giá trị là bắt buộc.',
            'array' => 'Trường giá trị phải là một mảng.',
        ],
        'variations' => [
            '.*.import_price' => [
                'nullable' => 'Giá nhập khẩu của từng biến thể là tùy chọn.',
            ],
        ],
    ],

    'create_product_request' => [
        'name' => [
            'required' => 'Tên sản phẩm là bắt buộc.',
            'string' => 'Tên sản phẩm phải là một chuỗi ký tự.',
            'max' => 'Tên sản phẩm quá dài, tối đa 255 ký tự.',
            'unique' => 'Tên sản phẩm đã tồn tại!'
        ],
        'price' => [
            'required' => 'Giá sản phẩm là bắt buộc.',
            'numeric' => 'Giá là phải số',
            'min' => 'Hãy nhập giá lớn hơn',
            'max' => 'Hãy nhập giá nhỏ hơn',
        ],
        'stock_qty' => [
            'required' => 'Số lượng tồn kho của sản phẩm là bắt buộc.',
            'numeric' => 'Số lượng tồn kho của sản phẩm phải là một số.',
            'min' => 'Hãy nhập số lượng sản phẩm lớn hơn',
            'max' => 'Hãy nhập số lượng nhỏ hơn',
        ],
        'image_url' => [
            'required' => 'Ảnh sản phẩm là bắt buộc.',
            'string' => 'Không tìm thấy ảnh sản phẩm. Vui lòng thử lại!',
        ],
        'import_price' => [
            'nullable' => 'Giá nhập khẩu là tùy chọn.',
        ],
        'description' => [
            'nullable' => 'Mô tả là tùy chọn.',
        ],
        'short_description' => [
            'nullable' => 'Mô tả ngắn là tùy chọn.',
        ],
        'images' => [
            'nullable' => 'Trường hình ảnh là tùy chọn.',
            'array' => 'Trường hình ảnh phải là một mảng.',
        ],
        'categories' => [
            'nullable' => 'Trường danh mục là tùy chọn.',
            'array' => 'Trường danh mục phải là một mảng.',
        ],
        'variations' => [
            '.*.price' => [
                'min' => 'Hãy nhập giá biến thể lớn hơn',
                'max' => 'Hãy nhập giá biến thể nhỏ hơn',
            ],
            '.*.stock_qty' => [
                'min' => 'Hãy nhập số lượng biến thể lớn hơn',
                'max' => 'Hãy nhập số lượng biến thể nhỏ hơn',
            ],
        ],
    ],

    'update_product_request' => [
        'name' => [
            'required' => 'Tên sản phẩm là bắt buộc.',
            'string' => 'Tên sản phẩm phải là một chuỗi văn bản.',
            'max' => 'Tên sản phẩm quá dài, tối đa 255 ký tự.',
        ],
        'price' => [
            'required' => 'Giá sản phẩm là bắt buộc.',
            'numeric' => 'Giá là phải số',
            'min' => 'Hãy nhập giá lớn hơn',
            'max' => 'Hãy nhập giá nhỏ hơn',
        ],
        'stock_qty' => [
            'required' => 'Số lượng sản phẩm trong kho là bắt buộc.',
            'numeric' => 'Số lượng sản phẩm trong kho phải là một số.',
            'min' => 'Hãy nhập số lượng sản phẩm lớn hơn',
            'max' => 'Hãy nhập số lượng nhỏ hơn',
        ],
        'image_url' => [
            'required' => 'Hình ảnh sản phẩm là bắt buộc.',
            'string' => 'Không tìm thấy hình ảnh sản phẩm. Vui lòng thử lại!',
        ],
        'import_price' => [
            'nullable' => 'Giá nhập khẩu là tùy chọn.',
        ],
        'description' => [
            'nullable' => 'Mô tả là tùy chọn.',
        ],
        'short_description' => [
            'nullable' => 'Mô tả ngắn là tùy chọn.',
        ],
        'images' => [
            'nullable' => 'Trường hình ảnh là tùy chọn.',
            'array' => 'Trường hình ảnh phải là một mảng.',
        ],
        'categories' => [
            'nullable' => 'Trường danh mục là tùy chọn.',
            'array' => 'Trường danh mục phải là một mảng.',
        ],
        'variations' => [
            '.*.price' => [
                'min' => 'Hãy nhập giá biến thể lớn hơn',
                'max' => 'Hãy nhập giá biến thể nhỏ hơn',
            ],
            '.*.stock_qty' => [
                'min' => 'Hãy nhập số lượng biến thể lớn hơn',
                'max' => 'Hãy nhập số lượng biến thể nhỏ hơn',
            ],
        ],


    ],

    'post_request' => [
        'title' => [
            'required' => 'Tiêu đề là bắt buộc.',
        ],
        'slug' => [
            'required' => 'Slug là bắt buộc.',
        ],
        'content' => [
            'required' => 'Nội dung là bắt buộc.',
        ],
        'topic_id' => [
            'required' => 'ID chủ đề là bắt buộc.',
        ],
        'author_id' => [
            'required' => 'ID tác giả là bắt buộc.',
        ],
    ],

    'create_order_request' => [
        'receiver_email' => [
            'required' => 'Email người nhận là bắt buộc.',
            'email' => 'Email không hợp lệ.',
        ],
        'total_amount' => [
            'required' => 'Số tiền tổng là bắt buộc.',
            'numeric' => 'Số tiền tổng phải là một giá trị số.',
            'max' => 'Gía trị đơn hàng quá lớn tối đa 2.000.000.000.',
        ],
        'payment_method' => [
            'required' => 'Phương thức thanh toán là bắt buộc.',
            'string' => 'Phương thức thanh toán phải là một chuỗi văn bản.',
            'min' => 'Giá trị phương thức thanh toán nhỏ nhất là 0',
            'max' => 'Phương thức thanh toán không được vượt quá 255 ký tự'
        ],
        'payment_status' => [
            'required' => 'Trạng thái thanh toán là bắt buộc.',
            'string' => 'Trạng thái thanh toán phải là một chuỗi văn bản.',
            'min' => 'Giá trị trạng thái thanh toán nhỏ nhất là 0',
            'max' => 'Trạng thái thanh toán không được vượt quá 255 ký tự'
        ],
        'shipping_method' => [
            'required' => 'Phương thức giao hàng là bắt buộc.',
            'string' => 'Phương thức giao hàng phải là một chuỗi văn bản.',
            'max' => 'Phương thức giao hàng không được vượt quá 255 ký tự'
        ],
        'shipping_cost' => [
            'required' => 'Chi phí vận chuyển là bắt buộc.',
            'numeric' => 'Chi phí vận chuyển phải là một giá trị số.',
            'min' => 'Giá trị chi phí giao hàng nhỏ nhất là 0'
        ],
        'amount_collected' => [
            'required' => 'Số tiền thu được là bắt buộc.',
            'numeric' => 'Số tiền thu được phải là một giá trị số.',
            'min' => 'Giá trị số tiền thu được nhỏ nhất là 0',
            'max' => 'Số tiền đơn hàng quá lớn, giá trị tối đa là 2.000.000.000.'
        ],
        'receiver_full_name' => [
            'required' => 'Họ và tên người nhận là bắt buộc.',
            'string' => 'Họ và tên người nhận phải là một chuỗi văn bản.',
            'max' => 'Họ tên không vượt quá 255 kí tự',
        ],
        'phone' => [
            'required' => 'Số điện thoại là bắt buộc.',
            'string' => 'Số điện thoại phải là một chuỗi văn bản.',
            'max' => 'Số điện thoại không quá 20 kí tự',
        ],
        'city' => [
            'required' => 'Thành phố là bắt buộc.',
            'string' => 'Thành phố phải là một chuỗi văn bản.',
            'max' => 'Thành phố không quá 255 kí tự',
        ],
        'country' => [
            'required' => 'Quốc gia là bắt buộc.',
            'string' => 'Quốc gia phải là một chuỗi văn bản.',
            'max' => 'Quốc gia không quá 255 kí tự',
        ],
        'address' => [
            'required' => 'Địa chỉ là bắt buộc.',
            'string' => 'Địa chỉ phải là một chuỗi văn bản.',
            'max' => 'Địa chỉ không quá 1024 kí tự',
        ],
        'status' => [
            'required' => 'Trạng thái là bắt buộc.',
        ],
        'user_id' => [
            'numeric' => 'Trường user_id phải là một số',
        ],
        'order_details' => [
            'required' => 'Chi tiết đơn hàng là bắt buộc.',

            '.*.price' => [
                'required' => 'Giá của từng chi tiết đơn hàng là bắt buộc',
                'numeric' => 'Giá của từng chi tiết đơn hàng phải là một số',
            ],
            '.*.quantity' => [
                'required' => 'Số lượng của từng chi tiết đơn hàng là bắt buộc',
                'numeric' => 'Số lượng của từng chi tiết đơn hàng phải là một số.',
            ],
            '.*.total_amount' => [
                'required' => 'Tổng số tiền của từng chi tiết đơn hàng là bắt buộc.',
                'numeric' => 'Tổng số tiền của từng chi tiết đơn hàng phải là một số.',
            ],
        ],
    ],
    'create_category_request' => [
        'name' => [
            'required' => 'Trường tên là bắt buộc.',
            'string' => 'Tên phải là một chuỗi văn bản.',
        ],
        'parents' => [
            'array' => 'Trường phụ huynh phải là một mảng.',
            'nullable' => 'Trường phụ huynh có thể để trống.',
        ],
    ],
    'update_category_request' => [
        'name' => [
            'required' => 'Trường tên là bắt buộc.',
            'string' => 'Tên phải là một chuỗi văn bản.',
        ],
        'parents' => [
            'array' => 'Trường phụ huynh phải là một mảng.',
            'nullable' => 'Trường phụ huynh có thể để trống.',
        ],
        'image_url' => [
            'nullable' => 'Trường URL hình ảnh có thể để trống.',
            'string' => 'URL hình ảnh phải là một chuỗi văn bản.',
        ],
    ],

    'add_cart_request' => [
        'user_id' => [
            'require' => 'User ID là bắt buộc.',
        ],
        'quantity' => [
            'require' => 'Số lượng là bắt buộc.',
        ],
    ],

    'password_request' => [
        'password' => [
            'required' => 'Mật khẩu là bắt buộc.',
            'string' => 'Mật khẩu phải là một chuỗi văn bản.',
        ],
        'newPassword' => [
            'required' => 'Mật khẩu mới là bắt buộc.',
            'min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'string' => 'Mật khẩu mới phải là một chuỗi văn bản.',
        ],
    ],

    'error_middleware' => [
        'error_custom' => 'Quá nhiều yêu cầu, vui lòng thử lại sau.',
        'error_isAdmin' => 'Không được phép.',
        'user_banned' => 'Tài khoản đã bị cấm!'
    ],
    'delete-category-forbidden' => 'Bạn không thể xóa danh mục này',
    'create_order_as_admin' => [
        'not_found_product' => 'Không thể tìm thấy một số sản phẩm. Đơn hàng sẽ không được tạo!',
        'out_of_stock' => ' không có đủ số lượng, vui lòng thử lại với đơn hàng khác',
        'not_found_user' => 'Tài khoản không thể tìm thấy!Hãy thử tạo lại đơn hàng!',
        'cannot_create' => 'Đã xảy ra lỗi! Không thể tạo đơn hàng'
    ],
    "update-order-out-of-qty" => "Một số sản phẩm đã hết số lượng.Không thể xử lí đơn hàng."
];
