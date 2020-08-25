<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes;
use App\Students;
use App\Http\Requests\StudentsRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class StudentsController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * 学生一覧画面
    */
    public function list()
    {
        $display = array();
        $display['heading'] = "Student Lists";

        $data = Students::getAllStudent();
        return view('admin.students.list', compact('data', 'display'));
    }

    /**
    * 学生表示画面
    *
    * @param $id
    * @return 学生ビュー画面へ移動する
    */
    public function view($id)
    {
        $display = array();
        $classlist = array();
        $display['heading'] = "Student View";
        $display['back'] = "Back";

        // 授業一覧
        $classlist = $this->setList(Classes::getClassList());

        // IDに該当する学生情報を取得する
        $dataedit = Students::where('student_id', '=', $id)->find($id);

        // 学生データは存在しない場合一覧画面へ移動する
        if (!$dataedit) {
            return redirect('students/list');
        }

        return view('admin.students.view', compact('display', 'classlist', 'dataedit'));
    }

    /**
    * 学生登録画面
    */
    public function add()
    {
        $display = array();
        $classlist = array();
        $display['heading'] = "Student Register";
        $display['button'] = "Register";

        // 事業一覧
        $classlist = $this->setList(Classes::getClassList());

        return view('admin.students.addedit', compact('display', 'classlist'));
    }

    /**
    * 学生情報を登録する
    *
    * @param $request
    * @return 学生ビュー画面へ移動する
    */
    public function doAdd(StudentsRequest $request) 
    {
        // 登録する
        $students = new Students($request->all());
        $students->save();

        if($students) {
          $message = "Students Record Created successfully!";
          $type = "success";
        } else {
          $message = "Students Record Created UnSuccessfully!";
          $type = "error";
        }

        return redirect()->route('students.list')->with($type, $message);
    }

    /**
    * 編集処理
    *
    * @param $id
    * @return 学生編集画面へ移動する
    */
    public function edit($id)
    {
        $display = array();
        $classlist = array();
        $display['heading'] = "Student Update";
        $display['button'] = "Update";

        // 授業一覧
        $classlist = $this->setList(Classes::getClassList());

        // IDに該当する学生情報を取得する
        $dataedit = Students::where('student_id', '=', $id)->find($id);

        // 学生データは存在しない場合一覧画面へ移動する
        if (!$dataedit) {
            return redirect('students/list');
        }

        return view('admin.students.addedit', compact('display', 'dataedit', 'classlist'));
    }

    /**
    * 更新処理
    *
    * @param $id
    * @return 学生編集画面へ移動する
    */
    public function doEdit(StudentsRequest $request) 
    {
        // 更新する
        $students = Students::findOrFail($request->student_id);
        $students->update($request->all());

        if($students) {
            $message = "Students Record Updated successfully!";
            $type = "success";
        } else {
            $message = "Students Record Updated UnSuccessfully!";
            $type = "error";
        }

        return redirect()->route('students.list')->with($type, $message);
    }

    /*配列の最初の値を空気でセットする*/
    private function setList($query) {
        $data = array();
        foreach ($query as $key => $value) {
            $data[''] = "";
            $data[$key] = $value;
        }

        return $data;
    }
}