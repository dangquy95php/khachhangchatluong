<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Models\User;

class ReportController extends Controller
{
    public static $dataMessage = [[
            'Bạn Không Có Đơn Nào Để Chốt. Chúng Tôi Cần Sự <span class="text-danger">HÀI HƯỚC</span> Của Bạn Và Sự <span class="text-danger">Cố Gắng</span> Của Bạn Hơn!',
            'Có Lẽ Hôm Nay Bạn Nhớ Người Yêu Cũ Nên Chưa Gọi Được Khách Nào!',
            'Khách Hàng Bảo Bạn Hài Hước Và Sẽ Chốt Đơn Với Bạn Sau',
            'Có Lẽ Trai Lạ Đến Văn Phòng Hay Sao Mà Hiệu Xuất Làm Việc Của Bạn Hơi Yếu!'
        ], [
            'Bạn Cần Nổ Lực Thêm Khi Chốt Đơn.',
            'Chắc Bạn Cũng Mệt Rồi. Thôi! Chuẩn Bị Về Với Tình Nhân Nhé!',
            'Ngày Nay Bạn Đã Ăn No Chưa. Sức Lực Làm Việc Của Bạn Hơi Chậm',
            'Bạn Đã Chốt Đơn! Khách Hàng Phản Hồi Bạn Rất Nhiệt Tình'
        ], [
            'Bạn Chốt Đơn Hơi Hơi Ít.',
            'Bạn Vừa Chốt Đơn Vừa Suy Nghĩ Tối Nay Đi Chơi Với Anh Nào Hả!',
            'Chốt Đơn Ít, Nhưng Vẫn Còn Muốn Chốt Thêm'
        ], [
            'Bạn Đã Không Ngừng Gọi Khách Chốt Đơn.',
            'Lòng Nhiệt Huyết Của Bạn Đã Làm Khách Hàng Phải Chốt Đơn',
        ], [
            'Bạn Tuyệt Vời Lắm Luôn Ý.',
            'Tuyệt Vời Không Thể Gì Tả Nổi',
            'Bạn Xứng Đáng Được Về Sớm Gặp TÌNH NHÂN.',
            'Bạn Rất Là Tuyệt Vời! Bạn Có Nôn Nóng Về Gặp Người Yêu Không Mà Chốt Đơn Liên Tục Hay Vậy?'
        ], [
            'Bạn Quá Đỉnh! Chốt Đơn Liên Tục.',
            'Đỉnh Lắm Bạn Ơi! Chốt Đơn Mệt Nghỉ',
            'Điều Gì Khiến Bạn Chốt Đơn Nhanh Vậy. Cảm Ơn Sự Cống Hiến Của Bạn'
        ] , [
            'CẢM ƠN BẠN RẤT NHIỀU. BẠN CHỐT ĐƠN QUÁ ĐỈNH, ĐỀ XUẤT BẠN LÊN LÀM QUẢN LÝ :D',
            'CẢM ƠN SỰ CỐNG HIẾN CỦA BẠN. BẠN ĐÃ VƯỢT QUÁ MỨC SỰ KÌ VỌNG! QUÁ ĐỈNH.',
            'TẠI SAO BẠN GIỎI ĐẾN VẬY. BẠN CÓ BÍ QUYẾT GÌ ĐỀ CHỐT ĐƠN LIÊN TỤC KHÔNG',
            'BẠN XỨNG ĐÁNG ĐƯỢC TUYÊN DƯƠNG, CẢM ƠN NGÀY LÀM VIỆC CỦA BẠN'
        ]
    ];

    public function index(Request $request)
    {
        $listCallOfStaff = User::with('customers_today_called')->orderBy('username', 'asc')->get();

        return view('report.index', compact('listCallOfStaff'));
    }

    public function ratings(Request $request)
    {
        $time = \Carbon\Carbon::now()->format('H:i:s');

        if ($time > '16:59:50' && $time < '17:00:10') {
            try {
                $ratings = User::with('customers_today_called')->where('username', '!=', 'admin')->where('username', '!=', 'NGUYENTHIEN')->orderBy('username', 'asc')->get();
                $result = [];
                foreach($ratings as &$datas) {
                    $appointment = 0;
                    $object = new \stdClass();

                    foreach($datas->customers_today_called as $item) {
                        if ($item->type_call == 0) {
                            $appointment++;
                        }
                    }
                    $object->name = $datas->name;
                    $object->appointment = $appointment;
                    $object->appointment_not_yet = count($datas->customers_today_called) - $appointment;

                    foreach(self::$dataMessage as $key => $data) {
                        if($key == $object->appointment) {
                            $object->message = $data[1];
                        }
                    }

                    if(count(self::$dataMessage) < $object->appointment) {
                        $object->message = self::$dataMessage[6][1];
                    }

                    if ($object->appointment != 0 || $object->appointment_not_yet != 0) {
                        $result[] = $object;
                    }
                }
            } catch (\Exception $ex) {
                return \Response::json(['data' => 'Có lỗi xảy ra'. $ex->getMessage()], 500);
            }

            $result = collect($result)->sortByDesc( function($item) {
                if ($item->appointment != 0) {
                    return [
                        $item->appointment, - $item->appointment_not_yet
                    ];
                } else {
                    return [
                        -$item->appointment, $item->appointment_not_yet
                    ];
                }
            });

            return \Response::json(['data' => $result->values()->all()], 200);
        }

        return \Response::json(['data' => 'Lỗi thời gian'], 500);
    }
}
