<?php

/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 11/07/2019
 * Time: 1:06 PM
 */
class Apps_Class_Upload extends Apps_Class_Database
{
    protected $tableName = "tbl_upload";
    protected $column = [
        "upload_id" => "",
        "upload_src" => "",
        "upload_name" => "",
        "upload_date" => ""
    ];
    protected $ext = [
        ".jpeg" => "",
        ".png" => "",
        ".jpg" => "",
        ".JPEG" => "",
        ".PNG" => "",
        ".JPG" => "",
        ".xml" => ""
    ];
    private $upload_path = "./resource/upload/";
    private $_file = [
        "name" => "",
        "size" => ""
    ];
    private $maxSize = 15;
    private $fileName = "";
    /**
     * Important must set File the first
     * @param $file
     */
    public function setFile($file)
    {
        if (isset($file) && gettype($file) == "array") $this->_file = $file;
        else Apps_Class_Log::writeLogFail("setFile Truyền file upload - file không tồn tại hoăc file gặp lỗi upload.php");
    }

    public function setUploadPath($path)
    {
        $this->upload_path = $path;
    }

    public function getUploadPath()
    {
        return $this->upload_path;
    }

    public function setMaxSize($size)
    {
        $this->maxSize = $size;
    }

    public function getExtension()
    {
        $pos = strpos($this->_file['name'], ".");
        $etc = substr($this->_file['name'], $pos);
        return $etc;
    }

    public function getWithoutExtension()
    {
        $pos = strpos($this->_file['name'], ".");
        $str = substr($this->_file['name'], 0, $pos);
        return $this->slug($str);
    }

    public function getRemoveExtension() {
        $pos = strpos($this->_file['name'], ".");
        $str = substr($this->_file['name'], 0, $pos);
        return $str;
    }

    public function checkError()
    {
        if ($this->_file['error'] == 0) return true;
        else return false;
    }

    public function checkExtension()
    {
        $flag = false;
        $etc = $this->getExtension();
        foreach ($this->ext as $key => $value) {
            if ($key == $etc) {
                $flag = true;
            }
        }
        return $flag;
    }

    public function getSize()
    {
        return round($this->_file['size'] * 0.000001, 2);
    }

    public function checkSize()
    {
        if ($this->getSize() > $this->maxSize)
            return false;
        else return true;
    }

    public function getTempFile()
    {
        return $this->_file['tmp_name'];
    }

    public function getName()
    {
        return $this->_file['name'];
    }

    public function checkFile()
    {
        if (!$this->checkError()) {
            Apps_Class_Log::writeLogFail("checkFile file không tồn tại hoặc lỗi upload.php");
            return false;
        } elseif (!$this->checkExtension()) {
            Apps_Class_Log::writeLogFail("checkFile file không đúng định dạng yêu cầu upload.php");
            return false;
        } elseif (!$this->checkSize()) {
            Apps_Class_Log::writeLogFail("checkFile dung lượng file vượt quá giới hạn cho phép " . $this->maxSize . " MB upload.php");
            return false;
        } else return true;
    }

    public function generateFolderAndFileName() {
        $folder = $this->upload_path . date("d-m-Y");
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        $this->fileName = date("d-m-Y") . "/" . rand(100, 99999999999) . "_" . rand(100, 99999999999) . "_" . rand(100, 99999999999) . $this->getExtension();
    }

    public function getFileName() {
        return $this->fileName;
    }

    public function upload()
    {
        if ($this->checkFile()) {
            $pathUpload = $this->upload_path . $this->fileName;
            $result = move_uploaded_file($this->getTempFile(), $pathUpload);
            if ($result) {
                Apps_Class_Log::writeLogSuccess("upload đã lưu file vào ổ cứng upload.php");
                $col = [
                    "upload_src" => $this->fileName,
                    "upload_name" => $this->getRemoveExtension(),
                    "upload_date" => date("Y-m-d")
                ];
                Apps_Class_Log::writeFlowLog("upload truyền tham số lưu file upload vào cơ sở dữ liệu upload.php");
                $this->setParam($col);
                if ($this->createData()) {
                    Apps_Class_Log::writeLogSuccess("upload đã lưu file " . $this->getName() . " vào cơ sỡ dữ liệu bảng " . $this->tableName . " upload.php");
                } else  Apps_Class_Log::writeLogFail("upload đã có lỗi xảy ra khi lưu " . $this->getName() . " vào cơ sở dữ liệu bảng " . $this->tableName . ", kiểm tra lại thông số truyền vào");
            } else Apps_Class_Log::writeLogFail("upload lưu file vào ổ cứng không thành công, kiểm tra lại đường dẫn upload.php");
        }
    }

    public function slug($str)
    {
        $str = strtolower($str);
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );

        foreach ($unicode as $nonUnicode => $uni) {

            $str = preg_replace("/($uni)/i", $nonUnicode, $str);

        }
        $str = str_replace(' ', '-', $str);

        return $str;
    }

    public function deleteFile($src)
    {
        $param = [
            "where" => "upload_src = '" . $src . "'"
        ];
        Apps_Class_Log::writeFlowLog("deleteFile truyền tham số xóa file upload.php");
        $this->setQuery($param);
        if ($this->deleteWithWhere()) {
            Apps_Class_Log::writeLogSuccess("deleteFile xóa file ".$src." trong cơ sỡ dữ liệu bảng " . $this->tableName . " upload.php");
            if (unlink("./resource/upload/".$src))
                Apps_Class_Log::writeLogSuccess("deleteFile đã xóa file " . $src . " trên ổ cứng upload.php");
            else Apps_Class_Log::writeLogFail("deleteFile xóa file " . $src . " trên ổ cứng thất bại, kiểm tra lại đường dẫn upload.php");
        } else Apps_Class_Log::writeLogFail("deleteFile không thể xóa file ".$src." trong cơ sỡ dữ liệu bảng " . $this->tableName . ", kiểm tra thông số truyền vào upload.php");
    }
}