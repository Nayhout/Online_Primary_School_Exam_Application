<?php

namespace App\Http\Controllers;

use App\SmBuilding;
use App\SmExamDate;
use App\SmFaculty;
use App\SmGeneration;
use App\SmPickUp;
use App\SmStudent;
use App\User;
use App\SmExam;
use ZipArchive;
use App\SmClass;
use App\SmStaff;
use App\SmStyle;
use App\Language;
use App\SmBackup;
use App\SmModule;
use App\SmSchool;
use App\SmCountry;
use App\SmSection;
use App\SmSession;
use App\SmSubject;
use App\YearCheck;
use App\SmCurrency;
use App\SmExamType;
use App\SmLanguage;
use App\SmTimeZone;
use App\SmsTemplate;
use App\SmCustomLink;
use App\SmDateFormat;
use App\SmSmsGateway;
use App\ApiBaseMethod;
use App\SmAcademicYear;
use App\SmEmailSetting;
use App\SmAssignSubject;
use App\SmSystemVersion;
use App\SmLanguagePhrase;
use App\SmPaymentMethhod;
use App\SmGeneralSettings;
use App\SmHomePageSetting;
use Illuminate\Http\Request;
use App\SmFrontendPersmission;
use App\SmPaymentGatewaySetting;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SmSystemSettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('PM');
        if (empty(Auth::user()->id)) {
            return redirect('login');
        }
    }

    public function news()
    {

        try {
            $exams       = SmExam::where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->get();
            $exams_types = SmExamType::where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->get();
            $classes     = SmClass::where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('active_status', 1)->get();
            $subjects    = SmSubject::where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('active_status', 1)->get();
            $sections    = SmSection::where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('active_status', 1)->get();
            return view('frontEnd.home.light_news', compact('exams', 'classes', 'subjects', 'exams_types', 'sections'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function notificationApi(Request $request)
    {

        try {
            return view('backEnd.api');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function flutterNotificationApi(Request $request)
    {

        try {
            $user = User::where('id', $request->id)->first();
            if ($user->notificationToken != '') {
                //echo 'Infix Edu';
                define('API_ACCESS_KEY', 'AAAAFyQhhks:APA91bGJqDLCpuPgjodspo7Wvp1S4yl3jYwzzSxet_sYQH9Q6t13CtdB_EiwD6xlVhNBa6RcHQbBKCHJ2vE452bMAbmdABsdPriJy_Pr9YvaM90yEeOCQ6VF7JEQ501Prhnu_2bGCPNp');
                //   $registrationIds = ;
                #prep the bundle
                $msg = array(
                    'body'     => $_REQUEST['body'],
                    'title'    => $_REQUEST['title'],

                );
                $fields = array(
                    'to'        => $user->notificationToken,
                    'notification'    => $msg
                );


                $headers = array(
                    'Authorization: key=' . API_ACCESS_KEY,
                    'Content-Type: application/json'
                );
                #Send Reponse To FireBase Server	
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);
                echo $result;
                curl_close($ch);
            } else {
                if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                    return ApiBaseMethod::sendError('Token not found');
                }
            }
        } catch (\Exception $e) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError($e);
            }
        }
    }
    // tableEmpty
    public function tableEmpty()
    {

        try {
            $sms_services = DB::table('migrations')->get();

            $tables                = DB::select('SHOW TABLES');
            $table_list            = [];
            $table_list_with_count = [];
            $tableString = 'Tables_in_' . DB::connection()->getDatabaseName();

            foreach ($tables as $table) {
                $table_name              = $table->$tableString;
                $table_list[]            = $table_name;
                $count                   = DB::table($table_name)->count();
                $table_list_with_count[] = $table->$tableString . '(' . $count . ')';
                // $table_strings[] = '$this->call('. $table_name.'Seeder::class);';

            }
            return view('backEnd.systemSettings.tableEmpty', compact('table_list', 'table_list_with_count'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    // end tableEmpty

    public function databaseDelete(Request $request)
    {
        try {
            $list_of_table = $request->permisions;

            if (empty($list_of_table)) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            }
            foreach ($list_of_table as $table) {

                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                DB::table($table)->truncate();
                //            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }

            $staff = new SmStaff();

            $staff->user_id        = Auth::user()->id;
            $staff->role_id        = 1;
            $staff->staff_no       = 1;
            $staff->designation_id = 1;
            $staff->department_id  = 1;
            $staff->first_name     = 'Super';
            $staff->last_name      = 'Admin';
            $staff->full_name      = 'Super Admin';
            $staff->fathers_name   = 'NA';
            $staff->mothers_name   = 'NA';

            $staff->date_of_birth   = '1980-12-26';
            $staff->date_of_joining = '2019-05-26';

            $staff->gender_id        = 1;
            $staff->email            = Auth::user()->email;
            $staff->mobile           = '';
            $staff->emergency_mobile = '';
            $staff->merital_status   = '';
            $staff->staff_photo      = 'public/uploads/staff/staff1.jpg';

            $staff->current_address   = '';
            $staff->permanent_address = '';
            $staff->qualification     = '';
            $staff->experience        = '';

            $staff->casual_leave    = '12';
            $staff->medical_leave   = '15';
            $staff->metarnity_leave = '45';

            $staff->driving_license         = '';
            $staff->driving_license_ex_date = '2019-02-23';
            $staff->save();

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function databaseRestory(Request $request)
    {

        try {
            set_time_limit(900);
            Artisan::call('db:seed');
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function displaySetting()
    {

        try {
            $sms_services       = SmSmsGateway::all();
            $active_sms_service = SmSmsGateway::select('id')->where('active_status', 1)->first();
            return view('backEnd.systemSettings.displaySetting', compact('sms_services', 'active_sms_service'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function smsSettings()
    {

        try {
            $sms_services       = SmSmsGateway::all();
            $active_sms_service = SmSmsGateway::select('id')->where('active_status', 1)->first();

            return view('backEnd.systemSettings.smsSettings', compact('sms_services', 'active_sms_service'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function languageSettings()
    {

        try {
            $sms_languages = SmLanguage::where('school_id', Auth::user()->school_id)->get();
            $all_languages = DB::table('languages')->where('school_id', Auth::user()->school_id)->orderBy('code', 'ASC')->get();
            return view('backEnd.systemSettings.languageSettings', compact('sms_languages', 'all_languages'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function languageEdit($id)
    {

        try {
            $selected_languages = SmLanguage::find($id);
            $sms_languages      = SmLanguage::where('school_id', Auth::user()->school_id)->get();
            $all_languages      = DB::table('languages')->where('school_id', Auth::user()->school_id)->orderBy('code', 'ASC')->get();
            return view('backEnd.systemSettings.languageSettings', compact('sms_languages', 'all_languages', 'selected_languages'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function languageUpdate(Request $request)
    {

        try {
            $id               = $request->id;
            $language_id      = $request->language_id;
            $language_details = Language::find($language_id);

            if (!empty($language_id)) {
                $sms_languages                     = SmLanguage::find($id);
                $sms_languages->language_name      = $language_details->name != null ? $language_details->name : '';
                $sms_languages->language_universal = $language_details->code;
                $sms_languages->native             = $language_details->native;
                $sms_languages->lang_id            = $language_details->id;

                $results = $sms_languages->save();
                if ($results) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect('language-settings');
                } else {
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }



    public function setEnvironmentValue()
    {

        try {
            $values['APP_LOCALE'] = 'en';
            $envFile = app()->environmentFilePath();
            $str = file_get_contents($envFile);
            if (count($values) > 0) {
                foreach ($values as $envKey => $envValue) {
                    $str .= "\n";
                    $keyPosition = strpos($str, "{$envKey}=");
                    $endOfLinePosition = strpos($str, "\n", $keyPosition);
                    $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                    if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                        $str .= "{$envKey}={$envValue}\n";
                    } else {
                        $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                    }
                }
            }
            $str = substr($str, 0, -1);
            $res = file_put_contents($envFile, $str);
            return $res;
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }



    public function ajaxLanguageChange(Request $request)
    {

        try {
            $uni = $request->id;
            SmLanguage::where('active_status', 1)->where('school_id', Auth::user()->school_id)->update(['active_status' => 0]);

            $updateLang = SmLanguage::where('language_universal', $uni)->where('school_id', Auth::user()->school_id)->first();
            $updateLang->active_status = 1;
            $updateLang->update();

            $values['APP_LOCALE'] = $updateLang->language_universal;
            $envFile = app()->environmentFilePath();
            $str = file_get_contents($envFile);
            if (count($values) > 0) {
                foreach ($values as $envKey => $envValue) {
                    $str .= "\n";
                    $keyPosition = strpos($str, "{$envKey}=");
                    $endOfLinePosition = strpos($str, "\n", $keyPosition);
                    $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                    if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                        $str .= "{$envKey}={$envValue}\n";
                    } else {
                        $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                    }
                }
            }
            $str = substr($str, 0, -1);
            $res = file_put_contents($envFile, $str);

            return response()->json([$updateLang]);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function ajaxSubjectDropdown(Request $request)
    {

        try {
            $class_id = $request->class;
            $allSubjects = SmAssignSubject::where([['section_id', '=', $request->id], ['class_id', $class_id]])->get();

            $subjectsName = [];
            foreach ($allSubjects as $allSubject) {
                $subjectsName[] = SmSubject::find($allSubject->subject_id);
            }

            return response()->json([$subjectsName]);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function languageAdd(Request $request)
    {


        $request->validate([
            // 'lang_id' => 'required|unique:sm_languages,lang_id|max:255',
            'lang_id' => 'required|max:255',
        ]);

        try {
            $lang_id          = $request->lang_id;
            $language_details = DB::table('languages')->where('id', $lang_id)->first();

            if (!empty($language_details)) {
                $sms_languages                     = new SmLanguage();
                $sms_languages->language_name      = $language_details->name;
                $sms_languages->language_universal = $language_details->code;
                $sms_languages->native             = $language_details->native;
                $sms_languages->lang_id            = $language_details->id;
                $sms_languages->active_status      = '0';
                $sms_languages->school_id      = Auth::user()->school_id;
                $results = $sms_languages->save();
                if ($results) {

                    if (Schema::hasColumn('sm_language_phrases', $language_details->code)) {
                        Toastr::success('Operation successful', 'Success');
                        return redirect('language-settings');
                    } else {
                        if (DB::statement('ALTER TABLE sm_language_phrases ADD ' . $language_details->code . ' text')) {
                            $column = $language_details->code;
                            $all_translation_terms = SmLanguagePhrase::all();
                            $jsonArr = [];
                            foreach ($all_translation_terms as $row) {
                                $lid          = $row->id;
                                $english_term = $row->en;
                                if (!empty($english_term)) {
                                    $update_translation_term                = SmLanguagePhrase::find($lid);
                                    $update_translation_term->$column       = $english_term;
                                    $update_translation_term->active_status = 1;
                                    $update_translation_term->save();
                                }
                            }
                            $path = base_path() . '/resources/lang/' . $language_details->code;
                            if (!file_exists($path)) {
                                File::makeDirectory($path, $mode = 0777, true, true);
                                $newPath      = $path . 'lang.php';
                                $page_content = "<?php
                                                    use App\SmLanguagePhrase;
                                                    \$getData = SmLanguagePhrase::where('active_status',1)->get();
                                                    \$LanguageArr=[];
                                                    foreach (\$getData as \$row) {
                                                        \$LanguageArr[\$row->default_phrases]=\$row->" . $language_details->code . ";
                                                    }
                                                    return \$LanguageArr;";
                                if (!file_exists($newPath)) {
                                    File::put($path . '/lang.php', $page_content);
                                }
                            }
                            Toastr::success('Operation successful', 'Success');
                            return redirect('language-settings');
                        } else {
                            Toastr::error('Operation Failed', 'Failed');
                            return redirect()->back();
                        }
                    }
                } else {
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            } //not empty language
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    //backupSettings
    public function backupSettings()
    {

        try {
            $sms_dbs = SmBackup::where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->orderBy('id', 'DESC')->get();
            return view('backEnd.systemSettings.backupSettings', compact('sms_dbs'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function BackupStore(Request $request)
    {
        $request->validate([
            'content_file' => 'required|file',
        ]);

        try {
            if ($request->file('content_file') != "") {
                $file = $request->file('content_file');
                if ($file->getClientOriginalExtension() == 'sql') {
                    $file_name = 'Restore_' . date('d_m_Y_') . $file->getClientOriginalName();
                    $file->move('public/databaseBackup/', $file_name);
                    $content_file = 'public/databaseBackup/' . $file_name;
                } else {
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            }

            if (isset($content_file)) {
                $store                = new SmBackup();
                $store->file_name     = $file_name;
                $store->source_link   = $content_file;
                $store->active_status = 1;
                $store->created_by    = Auth::user()->id;
                $store->updated_by    = Auth::user()->id;
                $result               = $store->save();
            }
            if ($result) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }

            $sms_dbs = SmBackup::orderBy('id', 'DESC')->get();
            return view('backEnd.systemSettings.backupSettings', compact('sms_dbs'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function languageSetup($language_universal)
    {

        try {
            $sms_languages = SmLanguagePhrase::where('active_status', 1)->get();
            $modules       = SmModule::all();

            return view('backEnd.systemSettings.languageSetup', compact('language_universal', 'sms_languages', 'modules'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function deleteDatabase($id)
    {

        try {
            $source_link = "";
            $data        = SmBackup::find($id);
            if (!empty($data)) {
                $source_link = $data->source_link;
                if (file_exists($source_link)) {
                    unlink($source_link);
                }
            }
            $result = SmBackup::where('id', $id)->delete();
            if ($result) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    //download database from public/databaseBackup
    public function downloadDatabase($id)
    {

        try {
            $source_link = "";
            $data        = SmBackup::where('id', $id)->first();
            if (!empty($data)) {
                $source_link = $data->source_link;
                if (file_exists($source_link)) {
                    unlink($source_link);
                }
            }

            if (file_exists($source_link)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($source_link) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($source_link));
                flush(); // Flush system output buffer
                readfile($source_link);
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    //restore database from public/databaseBackup
    public function restoreDatabase($id)
    {

        try {
            $sm_db = SmBackup::where('id', $id)->first();
            if (!empty($sm_db)) {
                $source_link = $sm_db->source_link;
            }

            $DB_HOST     = env("DB_HOST", "");
            $DB_DATABASE = env("DB_DATABASE", "");
            $DB_USERNAME = env("DB_USERNAME", "");
            $DB_PASSWORD = env("DB_PASSWORD", "");

            $connection = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE);

            if (!file_exists($source_link)) {
                Toastr::error('File not found', 'Failed');
                return redirect()->back();
            }
            $handle   = fopen($source_link, "r+");
            $contents = fread($handle, filesize($source_link));
            $sql      = explode(';', $contents);
            $flag     = 0;
            foreach ($sql as $query) {
                $result = mysqli_query($connection, $query);
                if ($result) {
                    $flag = 1;
                }
            }
            fclose($handle);

            if ($flag) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    //get files Backup #file
    public function getfilesBackup($id)
    {
        set_time_limit(1600);

        try {
            if ($id == 1) {
                $files             = base_path() . '/public/uploads';
                $created_file_name = 'Backup_' . date('d_m_Y_h:i') . '_Images.zip';
            } else if ($id == 2) {
                $files = base_path() . '';
                $created_file_name = 'Backup_' . date('d_m_Y_h:i') . '_Projects.zip';
            }

            Zipper::make(public_path($created_file_name))->add($files)->close();

            $store                = new SmBackup();
            $store->file_name     = $created_file_name;
            $store->source_link   = public_path($created_file_name);
            $store->active_status = 1;
            $store->file_type     = $id;
            $store->created_by    = Auth::user()->id;
            $store->updated_by    = Auth::user()->id;
            $result               = $store->save();
            if ($id == 2) {
                return response()->download(public_path($created_file_name));
            }
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    // download Files #file
    public function downloadFiles($id)
    {


        try {
            $sm_db       = SmBackup::where('id', $id)->first();
            $source_link = $sm_db->source_link;
            if (@file_exists(@$source_link)) {
                return response()->download($source_link);
            } else {
                Toastr::error('File not found', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function getDatabaseBackup()
    {

        try {
            $DB_HOST     = env("DB_HOST", "");
            $DB_DATABASE = env("DB_DATABASE", "");
            $DB_USERNAME = env("DB_USERNAME", "");
            $DB_PASSWORD = env("DB_PASSWORD", "");
            $connection  = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE);

            $tables = array();
            $result = mysqli_query($connection, "SHOW TABLES");
            while ($row = mysqli_fetch_row($result)) {
                $tables[] = $row[0];
            }
            $return = '';
            foreach ($tables as $table) {
                $result     = mysqli_query($connection, "SELECT * FROM " . $table);
                $num_fields = mysqli_num_fields($result);

                $return .= 'DROP TABLE ' . $table . ';';
                $row2 = mysqli_fetch_row(mysqli_query($connection, "SHOW CREATE TABLE " . $table));
                $return .= "\n\n" . $row2[1] . ";\n\n";

                for ($i = 0; $i < $num_fields; $i++) {
                    while ($row = mysqli_fetch_row($result)) {
                        $return .= "INSERT INTO " . $table . " VALUES(";
                        for ($j = 0; $j < $num_fields; $j++) {
                            $row[$j] = addslashes($row[$j]);
                            if (isset($row[$j])) {
                                $return .= '"' . $row[$j] . '"';
                            } else {
                                $return .= '""';
                            }
                            if ($j < $num_fields - 1) {
                                $return .= ',';
                            }
                        }
                        $return .= ");\n";
                    }
                }
                $return .= "\n\n\n";
            }

            if (!file_exists('public/databaseBackup')) {
                mkdir('public/databaseBackup', 0777, true);
            }

            //save file
            $name   = 'database_backup_' . date('d_m_Y_h:i') . '.sql';
            $path   = 'public/databaseBackup/' . $name;
            $handle = fopen($path, "w+");
            fwrite($handle, $return);
            fclose($handle);

            $get_backup                = new SmBackup();
            $get_backup->file_name     = $name;
            $get_backup->source_link   = $path;
            $get_backup->active_status = 1;
            $get_backup->file_type     = 0;
            $results                   = $get_backup->save();

            // $sms_dbs = SmBackup::orderBy('id', 'DESC')->get();
            // return view('backEnd.systemSettings.backupSettings', compact('sms_dbs'));

            if ($results) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function updateClickatellData()
    {

        try {
            $gateway_id          = $_POST['gateway_id'];
            $clickatell_username = $_POST['clickatell_username'];
            $clickatell_password = $_POST['clickatell_password'];
            $clickatell_api_id   = $_POST['clickatell_api_id'];

            if ($gateway_id) {
                $gatewayDetails = SmSmsGateway::where('id', $gateway_id)->first();
                if (!empty($gatewayDetails)) {

                    $gatewayDetailss                      = SmSmsGateway::find($gatewayDetails->id);
                    $gatewayDetailss->clickatell_username = $clickatell_username;
                    $gatewayDetailss->clickatell_password = $clickatell_password;
                    $gatewayDetailss->clickatell_api_id   = $clickatell_api_id;
                    $results                              = $gatewayDetailss->update();
                } else {

                    $gatewayDetail                      = new SmSmsGateway();
                    $gatewayDetail->clickatell_username = $clickatell_username;
                    $gatewayDetail->clickatell_password = $clickatell_password;
                    $gatewayDetail->clickatell_api_id   = $clickatell_api_id;
                    $results                            = $gatewayDetail->save();
                }
            }

            if ($results) {
                echo "success";
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function updateTwilioData()
    {


        try {
            $gateway_id                  = $_POST['gateway_id'];
            $twilio_account_sid          = $_POST['twilio_account_sid'];
            $twilio_authentication_token = $_POST['twilio_authentication_token'];
            $twilio_registered_no        = $_POST['twilio_registered_no'];

            if ($gateway_id) {
                $gatewayDetails = SmSmsGateway::where('id', $gateway_id)->first();
                if (!empty($gatewayDetails)) {

                    $gatewayDetailss                              = SmSmsGateway::find($gatewayDetails->id);
                    $gatewayDetailss->twilio_account_sid          = $twilio_account_sid;
                    $gatewayDetailss->twilio_authentication_token = $twilio_authentication_token;
                    $gatewayDetailss->twilio_registered_no        = $twilio_registered_no;
                    $results                                      = $gatewayDetailss->update();
                } else {

                    $gatewayDetail                              = new SmSmsGateway();
                    $gatewayDetail->twilio_account_sid          = $twilio_account_sid;
                    $gatewayDetail->twilio_authentication_token = $twilio_authentication_token;
                    $gatewayDetail->twilio_registered_no        = $twilio_registered_no;
                    $results                                    = $gatewayDetail->save();
                }
            }

            if ($results) {
                echo "success";
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function updateMsg91Data(Request $request)
    {


        try {
            $gateway_id                   = $request->gateway_id;
            $msg91_authentication_key_sid = $request->msg91_authentication_key_sid;
            $msg91_route                  = $request->msg91_route;
            $msg91_country_code           = $request->msg91_country_code;
            $msg91_sender_id              = $request->msg91_sender_id;

            $key1 = 'MSG91_KEY';
            $key2 = 'MSG91_SENDER_ID';
            $key3 = 'MSG91_COUNTRY';
            $key4 = 'MSG91_ROUTE';

            $value1 = $msg91_authentication_key_sid;
            $value2 = $msg91_sender_id;
            $value3 = $msg91_country_code;
            $value4 = $msg91_route;

            $path            = base_path() . "/.env";
            $MSG91_KEY       = env($key1);
            $MSG91_SENDER_ID = env($key2);
            $MSG91_COUNTRY   = env($key3);
            $MSG91_ROUTE     = env($key4);

            if (file_exists($path)) {
                file_put_contents($path, str_replace(
                    "$key1=" . $MSG91_KEY,
                    "$key1=" . $value1,
                    file_get_contents($path)
                ));
                file_put_contents($path, str_replace(
                    "$key2=" . $MSG91_SENDER_ID,
                    "$key2=" . $value2,
                    file_get_contents($path)
                ));
                file_put_contents($path, str_replace(
                    "$key3=" . $MSG91_COUNTRY,
                    "$key3=" . $value3,
                    file_get_contents($path)
                ));
                file_put_contents($path, str_replace(
                    "$key4=" . $MSG91_ROUTE,
                    "$key4=" . $value4,
                    file_get_contents($path)
                ));
            }

            if ($gateway_id) {
                $gatewayDetails = SmSmsGateway::where('id', $gateway_id)->first();
                if (!empty($gatewayDetails)) {

                    $gatewayDetailss                               = SmSmsGateway::find($gatewayDetails->id);
                    $gatewayDetailss->msg91_authentication_key_sid = $msg91_authentication_key_sid;
                    $gatewayDetailss->msg91_sender_id              = $msg91_sender_id;
                    $gatewayDetailss->msg91_route                  = $msg91_route;
                    $gatewayDetailss->msg91_country_code           = $msg91_country_code;
                    $results                                       = $gatewayDetailss->update();
                } else {

                    $gatewayDetail = new SmSmsGateway();

                    $gatewayDetail->msg91_authentication_key_sid = $msg91_authentication_key_sid;
                    $gatewayDetail->msg91_sender_id              = $msg91_sender_id;
                    $gatewayDetail->msg91_route                  = $msg91_route;
                    $gatewayDetail->msg91_country_code           = $msg91_country_code;

                    $results = $gatewayDetail->save();
                }
            }

            if ($results) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function activeSmsService()
    {

        try {
            $sms_service = $_POST['sms_service'];

            if ($sms_service) {
                $gatewayDetailss = SmSmsGateway::where('active_status', '=', 1)
                    ->update(['active_status' => 0]);
            }

            $gatewayDetails                = SmSmsGateway::find($sms_service);
            $gatewayDetails->active_status = 1;
            $results                       = $gatewayDetails->update();

            if ($results) {
                echo "success";
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function generalSettingsView(Request $request)
    {

        try {
            $editData = SmGeneralSettings::find(1);
            $session = SmGeneralSettings::join('sm_academic_years', 'sm_academic_years.id', '=', 'sm_general_settings.session_id')->find(1);
            // return $editData;
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {

                return ApiBaseMethod::sendResponse($editData, null);
            }
            return view('backEnd.systemSettings.generalSettingsView', compact('editData', 'session'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function updateGeneralSettings(Request $request)
    {

        try {
            $editData        = SmGeneralSettings::where('school_id', Auth::user()->school_id)->first();
            $session_ids     = SmAcademicYear::where('school_id', Auth::user()->school_id)->where('active_status', 1)->get();
            $dateFormats     = SmDateFormat::where('active_status', 1)->get();
            $languages       = SmLanguage::all();
            $countries       = SmCountry::select('currency')->groupBy('currency')->get();
            $currencies      = SmCurrency::all();
            $academic_years  = SmAcademicYear::where('school_id', Auth::user()->school_id)->get();
            $time_zones      = SmTimeZone::all();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data                = [];
                $data['editData']    = $editData;
                $data['session_ids'] = $session_ids->toArray();
                $data['dateFormats'] = $dateFormats->toArray();
                $data['languages']   = $languages->toArray();
                $data['countries']   = $countries->toArray();
                $data['currencies']  = $currencies->toArray();
                $data['academic_years']  = $academic_years->toArray();
                return ApiBaseMethod::sendResponse($data, 'apply leave');
            }
            return view('backEnd.systemSettings.updateGeneralSettings', compact('editData', 'session_ids', 'dateFormats', 'languages', 'countries', 'currencies', 'academic_years', 'time_zones'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function updateGeneralSettingsData(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'school_name'     => "required",
            'site_title'      => "required",
            'phone'           => "required",
            'email'           => "required",
            'session_id'      => "required",
            'language_id'     => "required",
            'date_format_id'  => "required",
            'currency'        => "required",
            'currency_symbol' => "required",
            'school_code' => "required",
            'time_zone' => "required",
            'promotionSetting' => "required",

        ]);

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        try {
            $id                               = 1;
            $generalSettData                  = SmGeneralSettings::find($id);
            $generalSettData->school_name     = $request->school_name;
            $generalSettData->site_title      = $request->site_title;
            $generalSettData->school_code     = $request->school_code;
            $generalSettData->address         = $request->address;
            $generalSettData->phone           = $request->phone;
            $generalSettData->email           = $request->email;
            $generalSettData->session_id      = $request->session_id;
            $generalSettData->language_id     = $request->language_id;
            $generalSettData->date_format_id  = $request->date_format_id;
            $generalSettData->currency        = $request->currency;
            $generalSettData->currency_symbol = $request->currency_symbol;
            $generalSettData->promotionSetting = $request->promotionSetting;
            $generalSettData->time_zone_id = $request->time_zone;

            $generalSettData->copyright_text = $request->copyright_text;

            $results = $generalSettData->save();


            if ($generalSettData->timeZone != "") {
                $value1 = $generalSettData->timeZone->time_zone;



                $key1 = 'APP_TIMEZONE';

                $path            = base_path() . "/.env";
                $APP_TIMEZONE       = env($key1);

                if (file_exists($path)) {
                    file_put_contents($path, str_replace(
                        "$key1=" . $APP_TIMEZONE,
                        "$key1=" . $value1,
                        file_get_contents($path)
                    ));
                }
            }

            $get_all_school_settings = SmGeneralSettings::get();

            foreach ($get_all_school_settings as $key => $school_setting) {
                $school_setup                  = SmGeneralSettings::find($school_setting->id);
                $school_setup->language_id     = $request->language_id;
                $school_setup->date_format_id  = $request->date_format_id;
                $school_setup->currency        = $request->currency;
                $school_setup->currency_symbol = $request->currency_symbol;
                $school_setup->time_zone_id = $request->time_zone;
                $school_setup->copyright_text = $request->copyright_text;
                $results = $school_setup->save();
            }
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($results) {
                    return ApiBaseMethod::sendResponse(null, 'General Settings has been updated successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again');
                }
            } else {
                if ($results) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect('general-settings');
                } else {
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function updateSchoolLogo(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'main_school_logo' => "sometimes|nullable|mimes:jpg,jpeg,png|max:50000",
            'main_school_favicon' => "sometimes|nullable|mimes:jpg,jpeg,png|max:50000",
        ]);

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // for upload School Logo
            if ($request->file('main_school_logo') != "") {
                $main_school_logo = "";
                $file             = $request->file('main_school_logo');
                $main_school_logo = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/settings/', $main_school_logo);
                $main_school_logo      = 'public/uploads/settings/' . $main_school_logo;
                $generalSettData       = SmGeneralSettings::find(1);
                $generalSettData->logo = $main_school_logo;
                $results               = $generalSettData->update();
            }
            // for upload School favicon
            else if ($request->file('main_school_favicon') != "") {
                $main_school_favicon = "";
                $file                = $request->file('main_school_favicon');
                $main_school_favicon = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/settings/', $main_school_favicon);
                $main_school_favicon      = 'public/uploads/settings/' . $main_school_favicon;
                $generalSettData          = SmGeneralSettings::find(1);
                $generalSettData->favicon = $main_school_favicon;
                $results                  = $generalSettData->update();
            } else {
                if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                    return ApiBaseMethod::sendError('No change applied, please try again');
                }
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
            if ($results) {
                if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                    return ApiBaseMethod::sendResponse(null, 'Logo has been updated successfully');
                }
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {
                if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                    return ApiBaseMethod::sendError('Something went wrong, please try again');
                }
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function emailSettings()
    {

        try {
            $editData = SmEmailSetting::find(1);
            return view('backEnd.systemSettings.emailSettingsView', compact('editData'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function updateEmailSettingsData(Request $request)
    {

        $request->validate([
            'from_name'         => "required",
            'from_email'        => "required",
        ]);


        if (
            $request->mail_username == ''
            || $request->mail_password == ''
            || $request->mail_encryption == ''
            || $request->mail_port == ''
            || $request->mail_host == '' || $request->mail_driver == ''
        ) {
            Toastr::error('All Field in Smtp Details Must Be filled Up', 'Failed');
            return redirect()->back();
        }


        try {

            $key1 = 'MAIL_USERNAME';
            $key2 = 'MAIL_PASSWORD';
            $key3 = 'MAIL_ENCRYPTION';
            $key4 = 'MAIL_PORT';
            $key5 = 'MAIL_HOST';
            $key6 = 'MAIL_DRIVER';

            $value1 = $request->mail_username;
            $value2 = $request->mail_password;
            $value3 = $request->mail_encryption;
            $value4 = $request->mail_port;
            $value5 = $request->mail_host;
            $value6 = $request->mail_driver;

            $path                   = base_path() . "/.env";
            $MAIL_USERNAME          = env($key1);
            $MAIL_PASSWORD          = env($key2);
            $MAIL_ENCRYPTION        = env($key3);
            $MAIL_PORT              = env($key4);
            $MAIL_HOST              = env($key5);
            $MAIL_DRIVER              = env($key6);

            if (file_exists($path)) {
                file_put_contents($path, str_replace(
                    "$key1=" . $MAIL_USERNAME,
                    "$key1=" . $value1,
                    file_get_contents($path)
                ));
                file_put_contents($path, str_replace(
                    "$key2=" . $MAIL_PASSWORD,
                    "$key2=" . $value2,
                    file_get_contents($path)
                ));
                file_put_contents($path, str_replace(
                    "$key3=" . $MAIL_ENCRYPTION,
                    "$key3=" . $value3,
                    file_get_contents($path)
                ));
                file_put_contents($path, str_replace(
                    "$key4=" . $MAIL_PORT,
                    "$key4=" . $value4,
                    file_get_contents($path)
                ));
                file_put_contents($path, str_replace(
                    "$key5=" . $MAIL_HOST,
                    "$key5=" . $value5,
                    file_get_contents($path)
                ));
                file_put_contents($path, str_replace(
                    "$key6=" . $MAIL_DRIVER,
                    "$key6=" . $value6,
                    file_get_contents($path)
                ));
            }



            $emailSettingsData = SmEmailSetting::select('id')->where('active_status', 1)->first();

            if (!empty($emailSettingsData)) {

                $emailSettData                    = SmEmailSetting::find(1);
                $emailSettData->from_name         = $request->from_name;
                $emailSettData->from_email        = $request->from_email;

                $emailSettData->mail_driver     = $request->mail_driver;
                $emailSettData->mail_host     = $request->mail_host;
                $emailSettData->mail_port       = $request->mail_port;
                $emailSettData->mail_username         = $request->mail_username;
                $emailSettData->mail_password     = $request->mail_password;
                $emailSettData->mail_encryption     = $request->mail_encryption;

                $results                          = $emailSettData->update();
            }

            if ($results) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function paymentMethodSettings()
    {
        try {
            $statement                = "SELECT P.id as PID, D.id as DID, P.active_status as IsActive, P.method, D.* FROM sm_payment_methhods as P, sm_payment_gateway_settings D WHERE P.gateway_id=D.id";
            $PaymentMethods           = DB::select($statement);
            $paymeny_gateway          = SmPaymentMethhod::all();
            $paymeny_gateway_settings = SmPaymentGatewaySetting::all();

            return view('backEnd.systemSettings.paymentMethodSettings', compact('PaymentMethods', 'paymeny_gateway', 'paymeny_gateway_settings'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function updatePaymentGateway(Request $request)
    {


        try {
            $paymeny_gateway = [
                'gateway_name', 'gateway_username', 'gateway_password', 'gateway_signature', 'gateway_client_id', 'gateway_mode',
                'gateway_secret_key', 'gateway_secret_word', 'gateway_publisher_key', 'gateway_private_key'
            ];
            $count          = 0;
            $gatewayDetails = SmPaymentGatewaySetting::where('gateway_name', $request->gateway_name)->first();

            foreach ($paymeny_gateway as $input_field) {
                if (isset($request->$input_field) && !empty($request->$input_field)) {
                    $gatewayDetails->$input_field = $request->$input_field;
                }
            }
            $results = $gatewayDetails->save();

            /*********** all ********************** */
            $WriteENV = SmPaymentGatewaySetting::all();
            foreach ($WriteENV as $row) {
                switch ($row->gateway_name) {
                    case 'PayPal':

                        $key1 = 'PAYPAL_ENV';
                        $key2 = 'PAYPAL_API_USERNAME';
                        $key3 = 'PAYPAL_API_PASSWORD';
                        $key4 = 'PAYPAL_API_SECRET';

                        $value1 = $row->gateway_mode;
                        $value2 = $row->gateway_username;
                        $value3 = $row->gateway_password;
                        $value4 = $row->gateway_secret_key;

                        $path                = base_path() . "/.env";
                        $PAYPAL_ENV          = env($key1);
                        $PAYPAL_API_USERNAME = env($key2);
                        $PAYPAL_API_PASSWORD = env($key3);
                        $PAYPAL_API_SECRET   = env($key4);

                        if (file_exists($path)) {
                            file_put_contents($path, str_replace(
                                "$key1=" . $PAYPAL_ENV,
                                "$key1=" . $value1,
                                file_get_contents($path)
                            ));
                            file_put_contents($path, str_replace(
                                "$key2=" . $PAYPAL_API_USERNAME,
                                "$key2=" . $value2,
                                file_get_contents($path)
                            ));
                            file_put_contents($path, str_replace(
                                "$key3=" . $PAYPAL_API_PASSWORD,
                                "$key3=" . $value3,
                                file_get_contents($path)
                            ));
                            file_put_contents($path, str_replace(
                                "$key4=" . $PAYPAL_API_SECRET,
                                "$key4=" . $value4,
                                file_get_contents($path)
                            ));
                        }

                        break;
                    case 'Stripe':

                        $key1 = 'PUBLISHABLE_KEY';
                        $key2 = 'SECRET_KEY';

                        $value1 = $row->gateway_publisher_key;
                        $value2 = $row->gateway_secret_key;

                        $path            = base_path() . "/.env";
                        $PUBLISHABLE_KEY = env($key1);
                        $SECRET_KEY      = env($key2);

                        if (file_exists($path)) {
                            file_put_contents($path, str_replace(
                                "$key1=" . $PUBLISHABLE_KEY,
                                "$key1=" . $value1,
                                file_get_contents($path)
                            ));
                            file_put_contents($path, str_replace(
                                "$key2=" . $SECRET_KEY,
                                "$key2=" . $value2,
                                file_get_contents($path)
                            ));
                        }

                        break;

                    case 'Paystack':

                        $key1 = 'PAYSTACK_PUBLIC_KEY';
                        $key2 = 'PAYSTACK_SECRET_KEY';
                        $key3 = 'PAYSTACK_PAYMENT_URL';
                        $key4 = 'MERCHANT_EMAIL';

                        $value1 = $row->gateway_publisher_key;
                        $value2 = $row->gateway_secret_key;
                        $value3 = 'https://api.paystack.co';
                        $value4 = $row->gateway_username;

                        $path                 = base_path() . "/.env";
                        $PAYSTACK_PUBLIC_KEY  = env($key1);
                        $PAYSTACK_SECRET_KEY  = env($key2);
                        $PAYSTACK_PAYMENT_URL = env($key3);
                        $MERCHANT_EMAIL       = env($key4);

                        if (file_exists($path)) {
                            file_put_contents($path, str_replace(
                                "$key1=" . $PAYSTACK_PUBLIC_KEY,
                                "$key1=" . $value1,
                                file_get_contents($path)
                            ));
                            file_put_contents($path, str_replace(
                                "$key2=" . $PAYSTACK_SECRET_KEY,
                                "$key2=" . $value2,
                                file_get_contents($path)
                            ));
                            file_put_contents($path, str_replace(
                                "$key3=" . $PAYSTACK_PAYMENT_URL,
                                "$key3=" . $value3,
                                file_get_contents($path)
                            ));
                            file_put_contents($path, str_replace(
                                "$key4=" . $MERCHANT_EMAIL,
                                "$key4=" . $value4,
                                file_get_contents($path)
                            ));
                        }
                        break;
                    case 'Razorpay':

                        $key1 = 'RAZORPAY_KEY';
                        $key2 = 'RAZORPAY_SECRET';


                        $value1 = $row->gateway_publisher_key;
                        $value2 = $row->gateway_secret_key;

                        $path                 = base_path() . "/.env";
                        $RAZORPAY_KEY  = env($key1);
                        $RAZORPAY_SECRET  = env($key2);

                        if (file_exists($path)) {
                            file_put_contents($path, str_replace(
                                "$key1=" . $RAZORPAY_KEY,
                                "$key1=" . $value1,
                                file_get_contents($path)
                            ));
                            file_put_contents($path, str_replace(
                                "$key2=" . $RAZORPAY_SECRET,
                                "$key2=" . $value2,
                                file_get_contents($path)
                            ));
                        }

                        break;
                }
            }

            /*********** all ********************** */

            if ($results) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function isActivePayment(Request $request)
    {
        // dd($request->gateways[1]);

        $request->validate(
            [
                'gateways' => 'required|array',
            ],
            [
                'gateways.required' => 'At least one gateway required!',
            ]
        );


        try {
            $update = SmPaymentMethhod::where('active_status', '=', 1)->update(['active_status' => 0]);

            foreach ($request->gateways as $pid => $isChecked) {
                $results = SmPaymentMethhod::where('id', '=', $pid)->update(['active_status' => 1]);
            }

            if ($results) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function updatePaypalData()
    {

        try {
            $gateway_id       = $_POST['gateway_id'];
            $paypal_username  = $_POST['paypal_username'];
            $paypal_password  = $_POST['paypal_password'];
            $paypal_signature = $_POST['paypal_signature'];
            $paypal_client_id = $_POST['paypal_client_id'];
            $paypal_secret_id = $_POST['paypal_secret_id'];

            if ($gateway_id) {
                $gatewayDetails = SmPaymentGatewaySetting::where('id', $gateway_id)->first();
                if (!empty($gatewayDetails)) {

                    $gatewayDetailss                   = SmPaymentGatewaySetting::find($gatewayDetails->id);
                    $gatewayDetailss->paypal_username  = $paypal_username;
                    $gatewayDetailss->paypal_password  = $paypal_password;
                    $gatewayDetailss->paypal_signature = $paypal_signature;
                    $gatewayDetailss->paypal_client_id = $paypal_client_id;
                    $gatewayDetailss->paypal_secret_id = $paypal_secret_id;
                    $results                           = $gatewayDetailss->update();
                } else {

                    $gatewayDetail                   = new SmPaymentGatewaySetting();
                    $gatewayDetail->paypal_username  = $paypal_username;
                    $gatewayDetail->paypal_password  = $paypal_password;
                    $gatewayDetail->paypal_signature = $paypal_signature;
                    $gatewayDetail->paypal_client_id = $paypal_client_id;
                    $gatewayDetail->paypal_secret_id = $paypal_secret_id;
                    $results                         = $gatewayDetail->save();
                }
            }

            if ($results) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {

                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function updateStripeData()
    {

        try {
            $gateway_id            = $_POST['gateway_id'];
            $stripe_api_secret_key = $_POST['stripe_api_secret_key'];
            $stripe_publisher_key  = $_POST['stripe_publisher_key'];

            if ($gateway_id) {
                $gatewayDetails = SmPaymentGatewaySetting::where('id', $gateway_id)->first();
                if (!empty($gatewayDetails)) {

                    $gatewayDetailss                        = SmPaymentGatewaySetting::find($gatewayDetails->id);
                    $gatewayDetailss->stripe_api_secret_key = $stripe_api_secret_key;
                    $gatewayDetailss->stripe_publisher_key  = $stripe_publisher_key;
                    $results                                = $gatewayDetailss->update();
                } else {

                    $gatewayDetail                        = new SmPaymentGatewaySetting();
                    $gatewayDetail->stripe_api_secret_key = $stripe_api_secret_key;
                    $gatewayDetail->stripe_publisher_key  = $stripe_publisher_key;
                    $results                              = $gatewayDetail->save();
                }
            }

            if ($results) {
                echo "success";
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function updatePayumoneyData()
    {

        try {
            $gateway_id       = $_POST['gateway_id'];
            $pay_u_money_key  = $_POST['pay_u_money_key'];
            $pay_u_money_salt = $_POST['pay_u_money_salt'];

            if ($gateway_id) {
                $gatewayDetails = SmPaymentGatewaySetting::where('id', $gateway_id)->first();
                if (!empty($gatewayDetails)) {

                    $gatewayDetailss                   = SmPaymentGatewaySetting::find($gatewayDetails->id);
                    $gatewayDetailss->pay_u_money_key  = $pay_u_money_key;
                    $gatewayDetailss->pay_u_money_salt = $pay_u_money_salt;
                    $results                           = $gatewayDetailss->update();
                } else {

                    $gatewayDetail                   = new SmPaymentGatewaySetting();
                    $gatewayDetail->pay_u_money_key  = $pay_u_money_key;
                    $gatewayDetail->pay_u_money_salt = $pay_u_money_salt;
                    $results                         = $gatewayDetail->save();
                }
            }

            if ($results) {
                echo "success";
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function activePaymentGateway()
    {

        try {
            $gateway_id = $_POST['gateway_id'];

            if ($gateway_id) {
                $gatewayDetailss = SmPaymentGatewaySetting::where('active_status', '=', 1)
                    ->update(['active_status' => 0]);
            }

            $results = SmPaymentGatewaySetting::where('gateway_name', '=', $gateway_id)
                ->update(['active_status' => 1]);

            if ($results) {
                echo "success";
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function languageDelete(Request $request)
    {

        $delete_directory = SmLanguage::find($request->id);

        DB::beginTransaction();

        try {

            if (DB::statement('ALTER TABLE sm_language_phrases DROP COLUMN ' . $delete_directory->language_universal)) {
                if ($delete_directory) {
                    $path = base_path() . '/resources/lang/' . $delete_directory->language_universal;
                    if (file_exists($path)) {
                        File::delete($path . '/lang.php');
                        rmdir($path);
                    }
                    $result = SmLanguage::destroy($request->id);
                    if ($result) {
                        Toastr::success('Operation successful', 'Success');
                        return redirect()->back();
                    }
                } else {
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            } //end drop table column

            DB::commit();
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function changeLocale($locale)
    {

        try {
            Session::put('locale', $locale);
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function changeLanguage($id)
    {

        try {
            SmLanguage::where('active_status', '=', 1)->where('school_id', Auth::user()->school_id)->update(['active_status' => 0]);
            $language                = SmLanguage::find($id);
            $language->active_status = 1;
            $language->save();
            Session::flash('langChange', 'Successfully Language Changed');
            return redirect()->to('locale/' . $language->language_universal);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function getTranslationTerms(Request $request)
    {

        try {
            $terms = SmLanguagePhrase::where('modules', $request->id)->get();
            return response()->json($terms);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function translationTermUpdate(Request $request)
    {

        $request->validate(
            [
                'module_id' => 'required',
                'language_universal' => 'required',
            ],
            [
                'module_id.required' => 'Please select at least one module',
            ]
        );



        try {
            $InputId            = $request->InputId;
            $language_universal = $request->language_universal;
            $LU                 = $request->LU;

            foreach ($InputId as $id) {
                $data                      = SmLanguagePhrase::find($id);
                $data->$language_universal = $LU[$id];
                $data->save();
            }
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    //Update System is Availalbe

    public function recurse_copy($src, $dst)
    {

        try {
            $dir = opendir($src);
            @mkdir($dst);
            while (false !== ($file = readdir($dir))) {
                if (($file != '.') && ($file != '..')) {
                    if (is_dir($src . '/' . $file)) {
                        $this->recurse_copy($src . '/' . $file, $dst . '/' . $file);
                    } else {
                        copy($src . '/' . $file, $dst . '/' . $file);
                    }
                }
            }
            closedir($dir);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    //Update System
    public function UpdateSystem()
    {

        try {
            $data = SmGeneralSettings::first();
            return view('backEnd.systemSettings.updateSettings', compact('data'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function databaseUpgrade()
    {

        try {
            $sql = base_path('database/infixv4_5_upgraded.sql');
            DB::unprepared(file_get_contents($sql));
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    //Update System
    public function AboutSystem()
    {

        try {
            $data = SmGeneralSettings::first();
            return view('backEnd.systemSettings.aboutSystem', compact('data'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }



    public function admin_UpdateSystem(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'content_file' => "required",
        ]);
        try {
            if (!file_exists('upgradeFiles')) {
                mkdir('upgradeFiles', 0777, true);
            }

            $fileName = "";
            if ($request->file('content_file') != "") {
                $file = $request->file('content_file');
                $fileName = time() . "." . $file->getClientOriginalExtension();
                $file->move('upgradeFiles/', $fileName);
                $fileName =  'upgradeFiles/' . $fileName;
            }


            $zip = new ZipArchive;
            $res = $zip->open($fileName);
            if ($res === TRUE) {
                $zip->extractTo('upgradeFiles/');
                $zip->close();
            } else {
                Toastr::error('Operation Failed, You have to select zip file', 'Failed');
                return redirect()->back();
            }
            $data = SmGeneralSettings::find(1);
            $data->system_version = $request->version_name;
            $data->save();
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function UpgradeSettings(Request $request)
    {
        Toastr::success('Operation successful', 'Success');
        return redirect()->back();
    }

    public function ajaxSelectCurrency(Request $request)
    {


        try {
            $select_currency_symbol = SmCurrency::select('symbol')->where('code', '=', $request->id)->first();

            $currency_symbol['symbol'] = $select_currency_symbol->symbol;

            return response()->json([$currency_symbol]);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    //ajax theme Style Active
    public function themeStyleActive(Request $request)
    {

        try {
            if ($request->id) {
                $modified = SmStyle::where('is_active', 1)->where('school_id', Auth::user()->school_id)->update(array('is_active' => 0));
                $selected = SmStyle::findOrFail($request->id);
                $selected->is_active = 1;
                $selected->save();
                return response()->json([$modified]);
            } else {
                return '';
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    //ajax theme Style Active
    public function themeStyleRTL(Request $request)
    {

        try {
            if ($request->id) {
                $selected = SmGeneralSettings::where('school_id', Auth::user()->school_id)->first();
                $selected->ttl_rtl = $request->id;
                $selected->save();
                return response()->json([$selected]);
            } else {
                return '';
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    //ajax session Active
    public function sessionChange(Request $request)
    {

        try {
            if ($request->id) {
                $data = SmAcademicYear::find($request->id);
                $selected = SmGeneralSettings::find(1);
                $selected->session_id = $request->id;
                $selected->session_year = $data->year;
                $selected->save();
                return response()->json([$selected]);
            } else {
                return '';
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /* ******************************** homePageBackend ******************************** */
    public function homePageBackend()
    {
        try {
            $links      = SmHomePageSetting::find(1);
            $permisions = SmFrontendPersmission::where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->where('parent_id', 1)->get();
            return view('backEnd.systemSettings.homePageBackend', compact('links', 'permisions'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function homePageUpdate(Request $request)
    {
        $request->validate([
            'title'             => 'required',
            'long_title'        => 'required',
            'short_description' => 'required',
            'permisions'        => 'required|array',
            'image' => "sometimes|nullable|mimes:jpg,jpeg,png|max:10000",
        ]);

        try {
            $permisionsArray = $request->permisions;
            $permisions      = SmFrontendPersmission::where('parent_id', 1)->update(['is_published' => 0]);
            foreach ($permisionsArray as $value) {
                $permisions = SmFrontendPersmission::where('id', $value)->update(['is_published' => 1]);
            }

            $image = "";
            if ($request->file('image') != "") {
                $file       = $request->file('image');
                $image_name = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $path       = 'public/uploads/homepage';
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $file->move($path . '/', $image_name);
                $image = $path . '/' . $image_name;
            }

            //Update Home Page
            $update                    = SmHomePageSetting::find(1);
            $update->title             = $request->title;
            $update->long_title        = $request->long_title;
            $update->short_description = $request->short_description;
            $update->link_label        = $request->link_label;
            $update->link_url          = $request->link_url;
            if ($request->file('image') != "") {
                $update->image = $image;
            }
            $result = $update->save();

            if ($result) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    /* ******************************** homePageBackend ******************************** */

    /* ******************************** customLinks ******************************** */

    public function customLinks()
    {

        try {
            $links = SmCustomLink::find(1);
            return view('backEnd.systemSettings.customLinks', compact('links'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function customLinksUpdate(Request $request)
    {


        try {
            $links = SmCustomLink::find(1);
            $lists = ['title1', 'link_label1', 'link_href1', 'link_label2', 'link_href2', 'link_label3', 'link_href3', 'link_label4', 'title2', 'link_href4', 'link_label5', 'link_href5', 'link_label6', 'link_href6', 'link_label7', 'link_href7', 'link_label8', 'link_href8', 'title3', 'link_label9', 'link_href9', 'link_label10', 'link_href10', 'link_label11', 'link_href11', 'link_label12', 'link_href12', 'title4', 'link_label13', 'link_href13', 'link_label14', 'link_href14', 'link_label15', 'link_href15', 'link_label16', 'link_href16', 'facebook_url', 'twitter_url', 'dribble_url', 'behance_url'];

            foreach ($lists as $list) {
                if (isset($request->$list)) {
                    $links->$list = $request->$list;
                }
                $result = $links->save();
            }

            if ($result) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    /* ******************************** customLinks ******************************** */

    public function getSystemVersion(Request $request)
    {

        try {
            $version = SmSystemVersion::find(1);
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data['SystemVersion'] = $version;
                return ApiBaseMethod::sendResponse($data, null);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function getSystemUpdate(Request $request, $version_upgrade_id = null)
    {

        try {
            $data = [];
            if (Schema::hasTable('sm_update_files')) {
                $version = DB::table('sm_update_files')->where('version_name', $version_upgrade_id)->first();
                if (!empty($version->path)) {
                    $url = url('/') . '/' . $version->path;
                    header("Location: " . $url);
                    die();
                } else {
                    return redirect()->back();
                }
            }
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function apiPermission()
    {


        try {
            if (!Schema::hasColumn('sm_general_settings', 'api_url')) {
                Schema::table('sm_general_settings', function ($table) {
                    $table->integer('api_url')->default(0)->nullable();
                });
            }
            $settings = SmGeneralSettings::find(1);

            return view('backEnd.systemSettings.apiPermission', compact('settings'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function apiPermissionUpdate(Request $request)
    {

        try {
            if ($request->status == 'on') {
                $status = 1;
            } else {
                $status = 0;
            }
            $user = SmGeneralSettings::find(1);
            $user->api_url = $status;
            $user->save();

            return response()->json($user);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /*** RTL TTL ***/

    public function create_a_dynamic_column($table_name, $column_name, $column_type, $column_limit)
    {
        try {
            if (!Schema::hasColumn($table_name, $column_name)) {
                Schema::table($table_name, function ($table, $column_name, $column_limit) {
                    $table->$column_type($column_name, $column_limit)->nullable();
                });
                return true;
            } else {
                return true;
            }
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }

    public function enable_rtl(Request $request)
    {

        try {
            if ($this->create_a_dynamic_column('sm_general_settings', 'ttl_rtl', 'integer', 11)) {
                $s = SmGeneralSettings::find(1);
                $s->ttl_rtl = $request->status;
                $s->save();
                return response()->json($s);
            } else {
                $s['flag'] = false;
                $s['message'] = 'something went wrong!!';
                return response()->json($s);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function buttonDisableEnable()
    {

        try {

            $settings = SmGeneralSettings::where('school_id', Auth::user()->school_id)->first();
            return view('backEnd.systemSettings.buttonDisableEnable', compact('settings'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function changeWebsiteBtnStatus(Request $request)
    {


        try {
            $gettings = SmGeneralSettings::where('school_id', Auth::user()->school_id)->first();
            $gettings->website_btn = $request->status;
            $gettings->save();
            return response()->json(null);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function changeDashboardBtnStatus(Request $request)
    {


        try {
            $gettings = SmGeneralSettings::where('school_id', Auth::user()->school_id)->first();
            $gettings->dashboard_btn = $request->status;
            $gettings->save();
            return response()->json(null);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function changeReportBtnStatus(Request $request)
    {

        try {
            $gettings = SmGeneralSettings::where('school_id', Auth::user()->school_id)->first();
            $gettings->report_btn = $request->status;
            $gettings->save();
            return response()->json(null);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function changeStyleBtnStatus(Request $request)
    {

        try {
            $gettings = SmGeneralSettings::where('school_id', Auth::user()->school_id)->first();
            $gettings->style_btn = $request->status;
            $gettings->save();
            return response()->json(null);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function changeLtlRtlBtnStatus(Request $request)
    {

        try {
            $gettings = SmGeneralSettings::where('school_id', Auth::user()->school_id)->first();
            $gettings->ltl_rtl_btn = $request->status;
            $gettings->save();
            return response()->json(null);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function changeLanguageBtnStatus(Request $request)
    {

        try {
            $gettings = SmGeneralSettings::where('school_id', Auth::user()->school_id)->first();
            $gettings->lang_btn = $request->status;
            $gettings->save();
            return response()->json(null);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function updateWebsiteUrl(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'website_url' => "url",
        ]);

        if ($validator->fails()) {

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {

            $settings = SmGeneralSettings::where('school_id', Auth::user()->school_id)->first();
            $settings->website_url = $request->website_url;
            $settings->save();
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function updateCreatedDate()
    {

        try {
            $path = base_path() . "/.env";
            $db_name = env('DB_DATABASE', null);
            $column = 'created_at';
            $table_list = DB::select("SELECT TABLE_NAME 
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE COLUMN_NAME ='$column'
                AND TABLE_SCHEMA='$db_name'");
            $tables = [];
            foreach ($table_list as $row) {
                $tables[] = $row->TABLE_NAME;
            }
            return $db_name;
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    // manage currency
    public function manageCurrency()
    {

        try {
            $session_ids = SmSession::where('active_status', 1)->where('school_id', '=', Auth::user()->school_id)->get();
            $currencies = SmCurrency::whereIn('school_id', array(1, Auth::user()->school_id))->get();
            $dateFormats = SmDateFormat::where('active_status', 1)->get();
            $languages = SmLanguage::whereOr(['school_id', Auth::user()->school_id], ['school_id', 1])->get();
            $countries = SmCountry::select('currency')->groupBy('currency')->get();
            $academic_years = SmAcademicYear::where('school_id', '=', Auth::user()->school_id)->get();
            return view('backEnd.systemSettings.manageCurrency', compact('session_ids', 'dateFormats', 'languages', 'countries', 'currencies', 'academic_years'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function storeCurrency(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required | max:25',
            'code' => 'required | max:15',
            'symbol' => 'required | max:15',
        ]);



        // school wise uquine validation 
        $is_duplicate = SmCurrency::where('school_id', Auth::user()->school_id)->where('name', $request->name)->where('code', $request->code)->first();
        if ($is_duplicate) {
            Toastr::error('Ops! Duplicate Found!', 'Failed');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // school wise uquine validation 
        // $is_duplicate = SmCurrency::where('school_id', Auth::user()->school_id)->where('code', $request->code)->first();
        // if ($is_duplicate) {
        //     Toastr::error('Ops! Duplicate  Code Found!', 'Failed');
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        // school wise uquine validation 
        // $is_duplicate = SmCurrency::where('school_id', Auth::user()->school_id)->where('symbol', $request->symbol)->first();
        // if ($is_duplicate) {
        //     Toastr::error('Ops! Duplicate Symbol Found!', 'Failed');
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }


        try {
            $s = new SmCurrency();
            $s->name = $request->name;
            $s->code = $request->code;
            $s->symbol = $request->symbol;
            $s->school_id = Auth::user()->school_id;
            $s->save();
            Toastr::success('Operation successful', 'Success');
            return redirect('manage-currency');

            $currencies = SmCurrency::whereOr(['school_id', Auth::user()->school_id], ['school_id', 1])->get();
            return view('backEnd.systemSettings.manageCurrency', compact('currencies'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function storeCurrencyUpdate(Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required | max:25',
            'code' => 'required | max:15',
            'symbol' => 'required | max:15',
        ]);


        // school wise uquine validation 
        $is_duplicate = SmCurrency::where('school_id', Auth::user()->school_id)->where('name', $request->name)->where('code', $request->code)->where('id', '!=', $request->id)->first();
        if ($is_duplicate) {
            Toastr::error('Ops! Duplicate Name Found!', 'Failed');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // school wise uquine validation 
        // $is_duplicate = SmCurrency::where('school_id', Auth::user()->school_id)->where('code', $request->code)->where('id','!=', $request->id)->first();
        // if ($is_duplicate) {
        //     Toastr::error('Ops! Duplicate  Code Found!', 'Failed');
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        // school wise uquine validation 
        // $is_duplicate = SmCurrency::where('school_id', Auth::user()->school_id)->where('symbol', $request->symbol)->where('id','!=', $request->id)->first();
        // if ($is_duplicate) {
        //     Toastr::error('Ops! Duplicate Symbol Found!', 'Failed');
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }



        try {
            $s = SmCurrency::findOrfail($request->id);
            $s->name = $request->name;
            $s->code = $request->code;
            $s->symbol = $request->symbol;
            $s->school_id = Auth::user()->school_id;
            $s->update();

            Toastr::success('Operation successful', 'Success');
            return redirect('manage-currency');

            $currencies = SmCurrency::whereOr(['school_id', Auth::user()->school_id], ['school_id', 1])->get();
            return view('backEnd.systemSettings.manageCurrency', compact('currencies'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect('manage-currency');
        }
    }
    public function manageCurrencyEdit($id)
    {

        try {
            $editData = SmCurrency::findOrfail($id);
            $currencies = SmCurrency::whereOr(['school_id', Auth::user()->school_id], ['school_id', 1])->get();

            return view('backEnd.systemSettings.manageCurrency', compact('editData', 'currencies'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect('manage-currency');
        }
    }
    public function manageCurrencyDelete($id)
    {
        try {
            $currency = SmCurrency::findOrfail($id);
            $currency->delete();
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {

            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function systemDestroyedByAuthorized()
    {
        try {
            return view('backEnd.systemSettings.manageCurrency', compact('editData', 'currencies'));
        } catch (\Exception $e) {

            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function schoolSettingsView(Request $request)
    {

        $editData = SmGeneralSettings::where('school_id', '=', Auth::user()->school_id)->first();
        $school = SmSchool::where('id', '=', Auth::user()->school_id)->first();

        $academic_year = SmAcademicYear::findOrfail(@$editData->session_id);
        if (ApiBaseMethod::checkUrl($request->fullUrl())) {

            return ApiBaseMethod::sendResponse($editData, null);
        }
        return view('saas::systemSettings.schoolGeneralSettingsView', compact('editData', 'school', 'academic_year'));
    }


    public function viewAsSuperadmin()
    {
        $school_id = Auth::user()->school_id;
        $role_id = Auth::user()->role_id;
        if ($school_id == 1 && $role_id == 1) {
            if (Session::get('isSchoolAdmin') == TRUE) {
                session(['isSchoolAdmin' => FALSE]);
                // Session::set('isSchoolAdmin', FALSE);
                Toastr::success('You are accessing as saas admin', 'Success');
                return redirect('superadmin-dashboard');
            } else {
                session(['isSchoolAdmin' => TRUE]);
                // Session::set('isSchoolAdmin', TRUE);
                Toastr::success('You are accessing as school admin', 'Success');
                return redirect('admin-dashboard');
            }
        }
    }






    public function SmsTemplate()
    {
        try {
            $template = SmsTemplate::first();
            return view('backEnd.systemSettings.sms_template', compact('template'));
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function SmsTemplateStore(Request $request, $id)
    {

        try {
            $data = SmsTemplate::find(1);
            $data->admission_pro = $request->admission_pro;
            $data->student_admit = $request->student_admit;
            $data->login_disable = $request->login_disable;
            $data->exam_schedule = $request->exam_schedule;
            $data->exam_publish = $request->exam_publish;
            $data->due_fees = $request->due_fees;
            $data->collect_fees = $request->collect_fees;
            $data->stu_promote = $request->stu_promote;
            $data->attendance_sms = $request->attendance_sms;
            $data->absent = $request->absent;
            $data->late_sms = $request->late_sms;
            $data->er_checkout = $request->er_checkout;
            $data->st_checkout = $request->st_checkout;
            $data->st_credentials = $request->st_credentials;
            $data->staff_credentials = $request->staff_credentials;
            $data->holiday = $request->holiday;
            $data->leave_app = $request->leave_app;
            $data->approve_sms = $request->approve_sms;
            $data->birth_st = $request->birth_st;
            $data->birth_staff = $request->birth_staff;
            $data->cheque_bounce = $request->cheque_bounce;
            $data->l_issue_b = $request->l_issue_b;
            $data->re_issue_book = $request->re_issue_book;
            $data->save();
            Toastr::success('Operation success', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function SmsTemplateNew()
    {
        try {
            $template = SmsTemplate::first();
            return view('backEnd.communicate.sms_template', compact('template'));
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function ExaminationDate(Request $request){
        $exam_date = SmExamDate::where('active_status', '=' , '1')->get();

        return view('backEnd.systemSettings.examination_date',compact('exam_date'));
    }

    public function ExaminationCreate(){
        $academic_year = SmAcademicYear::all();
        return view('backEnd.systemSettings.add_examination_date', compact('academic_year'));
    }

    public function storeExaminationDate(Request $request){
//        dd($request->all());
        $this->validate($request,[
           'name' => 'required',
           'academic' => 'required',
//           'note' => 'required',
        ]);
        try {
            $data = new SmExamDate();
            $data->name = $request->name;
            $data->academic = $request->academic;
            $data->note = $request->note;
            $data->save();
            Toastr::success('Operation success', 'Success');
            return redirect('examination-date');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function EditExaminationDate($id){
        $exam_date = SmExamDate::find($id);
        $academic_year = SmAcademicYear::all();
        return view('backEnd.systemSettings.examination_date_edit', compact('exam_date','academic_year'));
    }
    public function UpdateExaminationDate(Request $request){

        $exam_date = SmExamDate::find($request->id);
        $exam_date->name = $request->name;
        $exam_date->academic = $request->academic;
        $exam_date->note = $request->note;
        $result = $exam_date->save();

        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
            if ($result) {
                return ApiBaseMethod::sendResponse(null, 'Section has been updated successfully');
            } else {
                return ApiBaseMethod::sendError('Something went wrong, please try again.');
            }
        } else {
            if ($result) {
                Toastr::success('Operation successful', 'Success');

                return redirect('examination-date');
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        }



    }
    public function DeleteExaminationDate($id)
    {

        try{
            return view('backEnd.admin.deleteExaminationDate', compact('id'));
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function DeleteExamDate($id)
    {

        try {
            $exam_date = SmExamDate::find($id);
            $exam_date->active_status = '0';
            $exam_date->save();
            if ($exam_date )
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Illuminate\Database\QueryException $e) {

            $msg = 'This data already used, Please remove those data first';
            Toastr::error($msg, 'Failed');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }


    }
    public function GerationView(Request $request){
        $generation = SmGeneration::where('active_status', '=' , '1')->get();

        return view('backEnd.systemSettings.generation',compact('generation'));
    }
    public function AddGenerationStudent() {
        $academic_year = SmAcademicYear::all();
        return view('backEnd.systemSettings.add_generation_student', compact('academic_year'));
    }
    public function Generatestore(Request $request){
//        dd($request->all());
        $this->validate($request,[
            'generation_name' => 'required',
            'generation_name_kh' => 'required',
            'academic' => 'required',
        ]);
//        try {
            $data = new SmGeneration();
            $data->generation_name = $request->generation_name;
            $data->generation_name_kh = $request->generation_name_kh;
            $data->academic = $request->academic;
            $data->note = $request->note;
            $data->save();
            Toastr::success('Operation success', 'Success');
            return redirect('generate-student');
//        } catch (\Exception $e) {
//            Log::info($e->getMessage());
//            Toastr::error('Operation Failed', 'Failed');
//            return redirect()->back();
//        }
    }
    public function Generateedit($id){
        $generation = SmGeneration::find($id);
        $academic_year = SmAcademicYear::all();
        return view('backEnd.systemSettings.generation_student_edit', compact('generation','academic_year'));
    }
    public function GenerateUpdate(Request $request){

        $generation = SmGeneration::find($request->id);
        $generation->generation_name = $request->generation_name;
        $generation->generation_name_kh = $request->generation_name_kh;
        $generation->academic = $request->academic;
        $generation->note = $request->note;
        $result = $generation->save();

        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
            if ($result) {
                return ApiBaseMethod::sendResponse(null, 'Generation has been updated successfully');
            } else {
                return ApiBaseMethod::sendError('Something went wrong, please try again.');
            }
        } else {
            if ($result) {
                Toastr::success('Operation successful', 'Success');

                return redirect('generate-student');
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        }
    }
    public function DeleteGenerateStudent($id)
    {

        try{
            return view('backEnd.admin.deleteGenerationStudent', compact('id'));
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function GenerateDelete($id)
    {

        try {
            $generation = SmGeneration::find($id);
            $generation->active_status = '0';
            $generation->save();
            if ($generation )
                Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Illuminate\Database\QueryException $e) {

            $msg = 'This data already used, Please remove those data first';
            Toastr::error($msg, 'Failed');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }


    }
    public function index(Request $request){
        try {
            $faculties = SmFaculty::where('active_status', '=', 1)->get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse($faculties, null);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
        return view('backEnd.systemSettings.faculty',compact('faculties'));
    }

    public function FacultyStore(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'faculty_name' => "required|max:200|unique:sm_faculty,faculty_name," . $request->id,
            'faculty_name_kh' => "required|max:200|unique:sm_faculty,faculty_name_kh," . $request->id
        ]);

        $is_duplicate = SmFaculty::where('faculty_name', $request->faculty_name)->where('id','!=', $request->id)->first();
        if ($is_duplicate) {
            Toastr::error('Duplicate faculty name found!', 'Failed');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $academic_year=SmAcademicYear::where('school_id',Auth::user()->school_id)->first();
        if ($academic_year==null) {
            Toastr::warning('Create academic year first', 'Warning');
            return redirect()->back();
        }

        try {
            $faculty = new SmFaculty();
            $faculty->faculty_name = $request->faculty_name;
            $faculty->faculty_name_kh = $request->faculty_name_kh;
            $faculty->note = $request->note;
            $faculty->created_at = Auth::user()->id;
            $result = $faculty->save();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'Faculty has been created successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {
                if ($result) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect()->back();
                }
            }
        } catch (\Exception $e) {
            //dd($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function FacultyEdit(Request $request, $id)
    {

        try {
            $faculty = SmFaculty::find($id);
            $faculties = SmFaculty::where('active_status', '=', 1)->orderBy('id', 'desc')->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['faculty'] = $faculty->toArray();
                $data['faculties'] = $faculties->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }

            return view('backEnd.systemSettings.faculty', compact('faculty', 'faculties'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function FacultyUpdate(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'faculty_name' => "required|max:200|unique:sm_faculty,faculty_name," . $request->id
        ]);

        $is_duplicate = SmFaculty::where('faculty_name', $request->faculty_name)->where('id','!=', $request->id)->first();
        if ($is_duplicate) {
            Toastr::error('Duplicate faculty name found!', 'Failed');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $faculty = SmFaculty::find($request->id);
            $faculty->faculty_name = $request->faculty_name;
            $faculty->faculty_name_kh = $request->faculty_name_kh;
            $faculty->note = $request->note;
            $faculty->updated_at = Auth::user()->id;
            $result = $faculty->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'Faculty has been updated successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {
                if ($result) {
                    Toastr::success('Operation successful', 'Success');

                    return redirect('faculty');
                } else {
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function FacultyDelete(Request $request, $id)
    {
        try {
            $tables = \App\tableList::getTableList('faculty_id', $id);
            try {
                if ($tables == null) {
                    $delete_query = $faculty = SmFaculty::find($id);
                    $delete_query -> active_status = '0';
                    $delete_query->save();

                    if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                        if ($faculty) {
                            return ApiBaseMethod::sendResponse(null, 'Faculty has been deleted successfully');
                        } else {
                            return ApiBaseMethod::sendError('Something went wrong, please try again.');
                        }
                    } else {
                        if ($delete_query) {
                            Toastr::success('Operation successful', 'Success');
                            return redirect('faculty');
                        } else {
                            Toastr::error('Operation Failed', 'Failed');
                            return redirect()->back();
                        }
                    }
                } else {
                    $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                    Toastr::error($msg, 'Failed');
                    return redirect()->back();
                }
            } catch (\Illuminate\Database\QueryException $e) {

                $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                Toastr::error($msg, 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function Building(Request $request){
        try {
            $buildings = SmBuilding::where('active_status', '=', 1)->get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse($buildings, null);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
        return view('backEnd.systemSettings.building',compact('buildings'));
    }

    public function BuildingStore(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'building_name' => "required|max:200|unique:sm_building,building_name," . $request->id
        ]);
        $this->validate($request,[
            'building_name' => 'required',
            'building_name_kh' => 'required',
        ]);
        $is_duplicate = SmBuilding::where('building_name', $request->building_name)->where('id','!=', $request->id)->first();
        if ($is_duplicate) {
            if ($is_duplicate->active_status == null){
                $building = new SmBuilding();
                $building->building_name = $request->building_name;
                $building->building_name_kh = $request->building_name_kh;
                $building->note = $request->note;
                $building->code = $request->code;
                $building->created_by = Auth::user()->id;
                $result = $building->save();
                if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                    if ($result) {
                        return ApiBaseMethod::sendResponse(null, 'Building has been created successfully');
                    } else {
                        return ApiBaseMethod::sendError('Something went wrong, please try again.');
                    }
                } else {
                    if ($result) {
                        Toastr::success('Operation successful', 'Success');
                        return redirect()->back();
                    }
                }
            }
        }

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $academic_year=SmAcademicYear::where('school_id',Auth::user()->school_id)->first();
        if ($academic_year==null) {
            Toastr::warning('Create academic year first', 'Warning');
            return redirect()->back();
        }

        try {
            $building = new SmBuilding();
            $building->building_name = $request->building_name;
            $building->building_name_kh = $request->building_name_kh;
            $building->note = $request->note;
            $building->code = $request->code;
            $building->created_by = Auth::user()->id;
            $result = $building->save();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'Building has been created successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {
                if ($result) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect()->back();
                }
            }
        } catch (\Exception $e) {
            //dd($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function BuildingEdit(Request $request, $id)
    {

        try {
            $building = SmBuilding::find($id);
            $buildings = SmBuilding::where('active_status', '=', 1)->orderBy('id', 'desc')->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['building'] = $building->toArray();
                $data['buildings'] = $buildings->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }

            return view('backEnd.systemSettings.building', compact('building', 'buildings'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function BuildingUpdate(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'building_name' => "required|max:200|unique:sm_building,building_name," . $request->id
        ]);

        $is_duplicate = SmBuilding::where('building_name', $request->building_name)->where('id','!=', $request->id)->first();
        if ($is_duplicate) {
            Toastr::error('Duplicate Building name found!', 'Failed');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $building = SmBuilding::find($request->id);
            $building->building_name = $request->building_name;
            $building->building_name_kh = $request->building_name_kh;
            $building->note = $request->note;
            $building->code = $request->code;
            $building->updated_by = Auth::user()->id;
            $result = $building->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($result) {
                    return ApiBaseMethod::sendResponse(null, 'Building has been updated successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {
                if ($result) {
                    Toastr::success('Operation successful', 'Success');

                    return redirect('building');
                } else {
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function BuildingDelete(Request $request, $id)
    {
//        try {
//            $tables = tableList::getTableList('faculty_id', $id);
        try {
//                if ($tables == null) {
            $delete_query = $building = SmBuilding::find($id);
            $delete_query -> active_status = '0';
            $delete_query->save();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($building) {
                    return ApiBaseMethod::sendResponse(null, 'Building has been deleted successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {
                if ($delete_query) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect('building');
                } else {
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            }
//                } else {
//                    $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
//                    Toastr::error($msg, 'Failed');
//                    return redirect()->back();
//                }
//            } catch (\Illuminate\Database\QueryException $e) {
//
//                $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
//                Toastr::error($msg, 'Failed');
//                return redirect()->back();
//            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}
