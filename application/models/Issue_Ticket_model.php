<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Issue_Ticket_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }



    public function drop_job_type()
    {

        $sql_job_type = "SELECT 
        mjt_id,
        mjt_name_eng,
        mjt_name_thai
        FROM mst_job_type
        WHERE mjt_status_flg = 1";
        $query = $this->db->query($sql_job_type);
        $data = $query->result();

        return $data;
    }

    public function drop_tool()
    {
        $sql_tool = "SELECT mts_id,
        mts_name,
        mts_maker,
        mts_model
        FROM mst_tooling_system WHERE mts_status_flg =1";
        $query = $this->db->query($sql_tool);
        $data = $query->result();

        return $data;
    }

    public function drop_type()
    {
        $sql_tpye = "SELECT mtr_id,
        mtr_name,
        mtr_detail,
        mtr_status_flg
        FROM mst_type_request WHERE mtr_status_flg =1";
        $query = $this->db->query($sql_tpye);
        $data = $query->result();

        return $data;
    }


    public function drop_problem($selectedValue)
    {

        $sql_tool = "SELECT 
        t1.mpc_id,
        t1.mpc_name_eng,
        t1.mpc_name_thai,
        t1.mpc_status_flg,
        t1.mpc_detail
    FROM 
        mst_problem_condition t1
    LEFT JOIN
        mst_manage_worksheet t2 ON t1.mpc_id = t2.mpc_id
    WHERE 
        t1.mpc_type = 1 AND 
        t1.mpc_status_flg = 1 AND 
            t2.mjt_id = '$selectedValue' AND
        t2.mpc_id IS NOT NULL AND
            t2.mmw_status_flg = 1";
        $query = $this->db->query($sql_tool);
        $data = $query->result();

        return $data;
    }

    public function chkBox_problem()
    {
        $sql_pb = "SELECT 
        mpc_id,
        mpc_name_eng,
        mpc_name_thai,
        mpc_detail
    FROM 
        mst_problem_condition 
    WHERE 
        mpc_type = 5 AND mpc_status_flg = 1;";
        $query = $this->db->query($sql_pb);
        $data = $query->result();

        return $data;
    }

    public function radio_jobtype()
    {
        $sql_jbt = "SELECT 
        mjt_id,
        mjt_name_eng,
        mjt_name_thai,
        mjt_status_flg
    FROM 
        mst_job_type 
    WHERE 
        mjt_status_flg = 1;";
        $query = $this->db->query($sql_jbt);
        $data = $query->result();

        return $data;
    }

    public function drop_inspec_method($selectedValue)
    {
        $sql_inspec = "SELECT 
        t1.mim_id,
        t1.mim_name_eng,
        t1.mim_name_thai,
        t1.mim_status_flg,
        t1.mim_detail
        FROM 
        mst_inspection_method t1
        LEFT JOIN
        mst_manage_worksheet t2 ON t1.mim_id = t2.mim_id
        WHERE 
        t1.mim_type = 1 AND 
        t1.mim_status_flg = 1 AND 
        t2.mjt_id = '$selectedValue' AND
        t2.mim_id IS NOT NULL AND
        t2.mmw_status_flg = 1;";
        $query = $this->db->query($sql_inspec);
        $data = $query->result();

        return $data;
    }

    public function chkBox_inspection()
    {
        $sql_inspec = "SELECT 
        mim_id,
        mim_name_eng,
        mim_name_thai,
        mim_status_flg,
        mim_detail
    FROM 
        mst_inspection_method 
    WHERE 
        mim_type = 5 AND mim_status_flg = 1;";
        $query = $this->db->query($sql_inspec);
        $data = $query->result();

        return $data;
    }

    public function drop_trouble($selectedValue)
    {
        $sql_trouble = "SELECT 
        t1.mt_id,
        t1.mt_name_eng,
        t1.mt_name_thai,
        t1.mt_detail
        FROM 
        mst_troubleshooting t1
        LEFT JOIN
        mst_manage_worksheet t2 ON t1.mt_id = t2.mt_id
        WHERE 
        t1.mt_type = 1 AND 
        t1.mt_status_flg = 1 AND 
        t2.mjt_id = '$selectedValue' AND
        t2.mt_id IS NOT NULL AND
        t2.mmw_status_flg = 1";
        $query = $this->db->query($sql_trouble);
        $data = $query->result();

        return $data;
    }

    public function chkBox_trouble1()
    {
        $sql_trouble = "SELECT 
        mt_id,
        mt_name_eng,
        mt_name_thai,
        mt_status_flg,
        mt_detail
    FROM 
        mst_troubleshooting 
    WHERE 
        mt_type = 2 AND mt_status_flg = 1;";
        $query = $this->db->query($sql_trouble);
        $data = $query->result();

        return $data;
    }

    public function chkBox_trouble2()
    {
        $sql_trouble = "SELECT 
        mt_id,
        mt_name_eng,
        mt_name_thai,
        mt_status_flg,
        mt_detail
    FROM 
        mst_troubleshooting 
    WHERE 
        mt_type = 5 AND mt_status_flg = 1;";
        $query = $this->db->query($sql_trouble);
        $data = $query->result();

        return $data;
    }

    public function chkBox_analysis()
    {
        $sql_trouble = "SELECT 
        map_id,
        map_name,
        map_status_flg
    FROM 
        mst_analyze_problem 
    WHERE 
        map_status_flg = 1 ;";
        $query = $this->db->query($sql_trouble);
        $data = $query->result();

        return $data;
    }

    public function chkBox_delivery()
    {
        $sql_trouble = "SELECT 
        mde_id,
        mde_name,
        mde_status_flg
    FROM 
        mst_delivery_equipment 
    WHERE 
        mde_status_flg = 1 ;";
        $query = $this->db->query($sql_trouble);
        $data = $query->result();

        return $data;
    }

    public function save_issue($data, $sess)
    {


        $code = $this->get_reqCode();
        $areapd = $data["AreaPd"];
        $arealine = $data["AreaLine"];
        $areaother = $data["AreaOther"];
        $processfun = $data["ProcFunc"];
        $toolsys = $data["ToolSys"];
        $maker = $data["Maker"];
        $model = $data["Model"];

        $prodcon = $data["ProbCon"];
        $prodcondetail = $data["ProbConDetail"];
        $pbcheck1 = $data["PbCheckval1"];
        $pbcheck2 = $data["PbCheckval2"];
        $pbcheck3 = $data["PbCheckval3"];
        $prodconpic = $data["fileNamesPb"];
        $fileNames = explode(',', $prodconpic);


        $filteredFileNames = array();
        foreach ($fileNames as $fileName) {
            if (!empty($fileName)) {
                $filteredFileNames [] = $fileName;
            }
        }

        while (count($filteredFileNames) < 3) {
            $filteredFileNames[] = '';
        }

        // เตรียมข้อมูลสำหรับการใช้งานต่อไป
        $pbfileName1 = isset($filteredFileNames[0]) ? $filteredFileNames[0] : '';
        $pbfileName2 = isset($filteredFileNames[1]) ? $filteredFileNames[1] : '';
        $pbfileName3 = isset($filteredFileNames[2]) ? $filteredFileNames[2] : '';



        $jobtype = $data["JobtypeRadioVal"];


        $ispec = $data["InspecMethod"];
        $ispecdetail = $data["InspecDetail"];
        $inspeccheck1 = $data["InsCheckval1"];
        $inspeccheck2 = $data["InsCheckval2"];
        $inspeccheck3 = $data["InsCheckval3"];
        $inspecpic = $data["fileNamesIns"];
        $insfileNames = explode(',', $inspecpic);


        $insfilteredFileNames = array();
        foreach ($insfileNames as $insfileName) {
            if (!empty($insfileName)) {
                $insfilteredFileNames[] = $insfileName;
            }
        }

        while (count($insfilteredFileNames) < 3) {
            $insfilteredFileNames[] = '';
        }

        // เตรียมข้อมูลสำหรับการใช้งานต่อไป
        $insfileName1 = isset($insfilteredFileNames[0]) ? $insfilteredFileNames[0] : '';
        $insfileName2 = isset($insfilteredFileNames[1]) ? $insfilteredFileNames[1] : '';
        $insfileName3 = isset($insfilteredFileNames[2]) ? $insfilteredFileNames[2] : '';

        $trouble = $data["Trouble"];
        $troubledetail = $data["TroubleDetail"];

        $troubleCheckval1 = $data["TroubleCheckval1"];
        $troubleCheckval2 = $data["TroubleCheckval2"];
        $troubleCheckval3 = $data["TroubleCheckval3"];
        $troubleCheckval4 = $data["TroubleCheckval4"];
        $troubleDetail3 = $data["TroubleDetail3"];
        $troubleDetail4 = $data["TroubleDetail4"];

        $troublepic = $data["fileNamesTroub"];
        $troubfileNames = explode(',', $troublepic);


        $troubfilteredFileNames = array();
        foreach ($troubfileNames as $troubfileName) {
            if (!empty($troubfileName)) {
                $troubfilteredFileNames[] = $troubfileName;
            }
        }

        while (count($troubfilteredFileNames) < 3) {
            $troubfilteredFileNames[] = '';
        }

        // เตรียมข้อมูลสำหรับการใช้งานต่อไป
        $troubfileName1 = isset($troubfilteredFileNames[0]) ? $troubfilteredFileNames[0] : '';
        $troubfileName2 = isset($troubfilteredFileNames[1]) ? $troubfilteredFileNames[1] : '';
        $troubfileName3 = isset($troubfilteredFileNames[2]) ? $troubfilteredFileNames[2] : '';


        $deliverydetail = $data["Detaildelivery"];
        $deliveryCheckval1 = $data["deliveryCheckval1"];
        $deliveryCheckval2 = $data["deliveryCheckval2"];
        $deliveryCheckval3 = $data["deliveryCheckval3"];
        $deliveryCheckval4 = $data["deliveryCheckval4"];
        $deliveryCheckval5 = $data["deliveryCheckval5"];
        $deliveryCheckval6 = $data["deliveryCheckval6"];


        $analyzdetail = $data["AnalyzDetail"];
        $analyzcheck1 = $data["Checkval1"];
        $analyzcheck2 = $data["Checkval2"];
        $analyzcheck3 = $data["Checkval3"];
        $analyzcheck4 = $data["Checkval4"];
        $analyzcheck5 = $data["Checkval5"];
        $analyzcheck6 = $data["Checkval6"];
        $analyzcheck7 = $data["Checkval7"];
        $analyzcheck8 = $data["Checkval8"];
        $analyzcheck9 = $data["Checkval9"];
        $analyzcheck10 = $data["Checkval10"];
        $analyzcheck11 = $data["Checkval11"];
        $detailcheck11 = $data["Detailcheck11"];

        $analyzpic = $data["fileNamesTroub"];
        $analyzfileNames = explode(',', $analyzpic);


        $analyzFileNames = array();
        foreach ($analyzfileNames as $anafileName) {
            if (!empty($anafileName)) {
                $analyzFileNames[] = $anafileName;
            }
        }

        while (count($analyzFileNames) < 3) {
            $analyzFileNames[] = '';
        }

        // เตรียมข้อมูลสำหรับการใช้งานต่อไป
        $anafileName1 = isset($analyzFileNames[0]) ? $analyzFileNames[0] : '';
        $anafileName2 = isset($analyzFileNames[1]) ? $analyzFileNames[1] : '';
        $anafileName3 = isset($analyzFileNames[2]) ? $analyzFileNames[2] : '';



        $sql_insert_issue_ticket = "INSERT INTO info_issue_ticket (
        ist_type,
        ist_pd,
        ist_line_cd,
        ist_area_other,
        ist_process,
        ist_tool,
        ist_maker,
        ist_model,
        ist_job_no,
        ist_date,
        mjt_id,
        mpc_id,
        mim_id,
        mt_id,
        ist_request_by,
        ist_request_time,
        ist_status_flg,
        ist_created_date,
        ist_created_by) 
        VALUES (2,'$areapd','$arealine','$areaother','$processfun','$toolsys','$maker','$model','$code',NOW(),'$jobtype','$prodcon','$ispec','$trouble','$sess',NOW(),3,NOW(),'$sess')";

        $query_insert_issue_ticket = $this->db->query($sql_insert_issue_ticket);

        if ($this->db->affected_rows() > 0) {
            // ดึง ist_id ที่เพิ่งถูกสร้างขึ้น
            $sql_select_ist_id = "SELECT ist_id FROM info_issue_ticket WHERE ist_created_by = '$sess' ORDER BY ist_id DESC LIMIT 1";
            $query_select_ist_id = $this->db->query($sql_select_ist_id);

            if ($query_select_ist_id->num_rows() > 0) {
                $row = $query_select_ist_id->row();
                $ist_id = $row->ist_id;

                // INSERT INTO info_problem_condition
                $sql_insert_problem_condition = "INSERT INTO info_problem_condition (
                ist_id,
                mpc_id,
                ipc_detail,
                ipc_pic_1,
                ipc_pic_2,
                ipc_pic_3,
                ipc_path,
                ipc_status_flg,
                ipc_created_date,
                ipc_created_by
            ) VALUES ('$ist_id','$prodcon','$prodcondetail','$pbfileName1','$pbfileName2','$pbfileName3','assets/img/upload/problem/',1,NOW(),'$sess')";

                $query_insert_problem_condition = $this->db->query($sql_insert_problem_condition);

                if ($pbcheck1 !== '') {
                    $sql_insert_problem_1 = "INSERT INTO info_problem_condition (
                        ist_id,
                        mpc_id,
                        ipc_status_flg,
                        ipc_created_date,
                        ipc_created_by)
                    VALUES ('$ist_id','$pbcheck1',1,NOW(),'$sess')";

                    $query_insert_problem_1 = $this->db->query($sql_insert_problem_1);

                    if ($this->db->affected_rows() > 0) {
                        // เพิ่มข้อมูลสำเร็จ
                        // ทำตามขั้นตอนที่คุณต้องการเพิ่มเติม
                    } else {
                        // ไม่สามารถเพิ่มข้อมูลได้
                    }
                }

                if ($pbcheck2 !== '') {
                    $sql_insert_problem_2 = "INSERT INTO info_problem_condition (
                        ist_id,
                        mpc_id,
                        ipc_status_flg,
                        ipc_created_date,
                        ipc_created_by)
                    VALUES ('$ist_id','$pbcheck2',1,NOW(),'$sess')";

                    $query_insert_problem_2 = $this->db->query($sql_insert_problem_2);

                    if ($this->db->affected_rows() > 0) {
                        // เพิ่มข้อมูลสำเร็จ
                        // ทำตามขั้นตอนที่คุณต้องการเพิ่มเติม
                    } else {
                        // ไม่สามารถเพิ่มข้อมูลได้
                    }
                }

                if ($pbcheck3 !== '') {
                    $sql_insert_problem_3 = "INSERT INTO info_problem_condition (
                        ist_id,
                        mpc_id,
                        ipc_status_flg,
                        ipc_created_date,
                        ipc_created_by)
                    VALUES ('$ist_id','$pbcheck3',1,NOW(),'$sess')";

                    $query_insert_problem_3 = $this->db->query($sql_insert_problem_3);

                    if ($this->db->affected_rows() > 0) {
                        // เพิ่มข้อมูลสำเร็จ
                        // ทำตามขั้นตอนที่คุณต้องการเพิ่มเติม
                    } else {
                        // ไม่สามารถเพิ่มข้อมูลได้
                    }
                }



                $sql_insert_troubleshooting = "INSERT INTO info_troubleshooting (ist_id,
                mt_id,
                it_detail,
                it_pic_1,
                it_pic_2,
                it_pic_3,
                it_path,
                it_status_flg,
                it_created_date,
                it_created_by
            ) VALUES ('$ist_id','$trouble','$troubledetail','$troubfileName1','$troubfileName2','$troubfileName3','assets/img/upload/trouble/',1,NOW(),'$sess')";

                $query_insert_troubleshooting = $this->db->query($sql_insert_troubleshooting);



                if ($troubleCheckval1 !== '') {
                    $sql_insert_troubel_1 = "INSERT INTO info_troubleshooting (
                        ist_id,
                        mt_id,
                        it_status_flg,
                        it_created_date,
                        it_created_by)
                    VALUES ('$ist_id','$troubleCheckval1',1,NOW(),'$sess')";

                    $query_insert_troubel_1 = $this->db->query($sql_insert_troubel_1);

                    if ($this->db->affected_rows() > 0) {
                        // เพิ่มข้อมูลสำเร็จ
                        // ทำตามขั้นตอนที่คุณต้องการเพิ่มเติม
                    } else {
                        // ไม่สามารถเพิ่มข้อมูลได้
                    }
                }

                if ($troubleCheckval2 !== '') {
                    $sql_insert_troubel_2 = "INSERT INTO info_troubleshooting (
                            ist_id,
                            mt_id,
                            it_status_flg,
                            it_created_date,
                            it_created_by)
                        VALUES ('$ist_id','$troubleCheckval2',1,NOW(),'$sess')";

                    $query_insert_troubel_2 = $this->db->query($sql_insert_troubel_2);

                    if ($this->db->affected_rows() > 0) {
                        // เพิ่มข้อมูลสำเร็จ
                        // ทำตามขั้นตอนที่คุณต้องการเพิ่มเติม
                    } else {
                        // ไม่สามารถเพิ่มข้อมูลได้
                    }
                }

                if ($troubleCheckval3 !== '') {
                    $sql_insert_troubel_3 = "INSERT INTO info_troubleshooting (
                                ist_id,
                                mt_id,
                                it_detail,
                                it_status_flg,
                                it_created_date,
                                it_created_by)
                            VALUES ('$ist_id','$troubleCheckval3','$troubleDetail3',1,NOW(),'$sess')";

                    $query_insert_troubel_3 = $this->db->query($sql_insert_troubel_3);

                    if ($this->db->affected_rows() > 0) {
                        // เพิ่มข้อมูลสำเร็จ
                        // ทำตามขั้นตอนที่คุณต้องการเพิ่มเติม
                    } else {
                        // ไม่สามารถเพิ่มข้อมูลได้
                    }
                }

                if ($troubleCheckval4 !== '') {
                    $sql_insert_troubel_4 = "INSERT INTO info_troubleshooting (
                                    ist_id,
                                    mt_id,
                                    it_detail,
                                    it_status_flg,
                                    it_created_date,
                                    it_created_by)
                                VALUES ('$ist_id','$troubleCheckval4','$troubleDetail4',1,NOW(),'$sess')";

                    $query_insert_troubel_4 = $this->db->query($sql_insert_troubel_4);

                    if ($this->db->affected_rows() > 0) {
                        // เพิ่มข้อมูลสำเร็จ
                        // ทำตามขั้นตอนที่คุณต้องการเพิ่มเติม
                    } else {
                        // ไม่สามารถเพิ่มข้อมูลได้
                    }
                }











                if ($inspeccheck1 !== '') {
                    $sql_insert_inspec_1 = "INSERT INTO info_inspection_method (
                        ist_id,
                        mim_id,
                        iim_status_flg,
                        iim_created_date,
                        iim_created_by)
                    VALUES ('$ist_id','$inspeccheck1',1,NOW(),'$sess')";

                    $query_insert_inspec_1 = $this->db->query($sql_insert_inspec_1);

                    if ($this->db->affected_rows() > 0) {
                        // เพิ่มข้อมูลสำเร็จ
                        // ทำตามขั้นตอนที่คุณต้องการเพิ่มเติม
                    } else {
                        // ไม่สามารถเพิ่มข้อมูลได้
                    }
                }

                if ($inspeccheck2 !== '') {
                    $sql_insert_inspec_2 = "INSERT INTO info_inspection_method (
                        ist_id,
                        mim_id,
                        iim_status_flg,
                        iim_created_date,
                        iim_created_by)
                    VALUES ('$ist_id','$inspeccheck2',1,NOW(),'$sess')";

                    $query_insert_inspec_2 = $this->db->query($sql_insert_inspec_2);

                    if ($this->db->affected_rows() > 0) {
                        // เพิ่มข้อมูลสำเร็จ
                        // ทำตามขั้นตอนที่คุณต้องการเพิ่มเติม
                    } else {
                        // ไม่สามารถเพิ่มข้อมูลได้
                    }
                }

                if ($inspeccheck3 !== '') {
                    $sql_insert_inspec_3 = "INSERT INTO info_inspection_method (
                        ist_id,
                        mim_id,
                        iim_status_flg,
                        iim_created_date,
                        iim_created_by)
                    VALUES ('$ist_id','$inspeccheck3',1,NOW(),'$sess')";

                    $query_insert_inspec_3 = $this->db->query($sql_insert_inspec_3);

                    if ($this->db->affected_rows() > 0) {
                        // เพิ่มข้อมูลสำเร็จ
                        // ทำตามขั้นตอนที่คุณต้องการเพิ่มเติม
                    } else {
                        // ไม่สามารถเพิ่มข้อมูลได้
                    }
                }


                if ($deliveryCheckval1 !== '') {
                    $sql_insert_delivery_1 = "INSERT INTO info_delivery_equipment (
                    ist_id,
                    mde_id,
                    ide_detail,
                    ide_status_flg,
                    ide_created_date,
                    ide_created_by)
                    VALUES ('$ist_id','$deliveryCheckval1','$deliverydetail',1,NOW(),'$sess')";

                    $query_insert_delivery_1 = $this->db->query($sql_insert_delivery_1);

                    if ($this->db->affected_rows() > 0) {
                        // เพิ่มข้อมูลสำเร็จ
                        // ทำตามขั้นตอนที่คุณต้องการเพิ่มเติม
                    } else {
                        // ไม่สามารถเพิ่มข้อมูลได้
                    }
                }

                // เพิ่ม query INSERT สำหรับ $deliveryCheckval2
                if ($deliveryCheckval2 !== '') {
                    $sql_insert_delivery_2 = "INSERT INTO info_delivery_equipment (
                    ist_id,
                    mde_id,
                    ide_status_flg,
                    ide_created_date,
                    ide_created_by)
                    VALUES ('$ist_id','$deliveryCheckval2',1,NOW(),'$sess')";

                    $query_insert_delivery_2 = $this->db->query($sql_insert_delivery_2);

                    if ($this->db->affected_rows() > 0) {
                        // เพิ่มข้อมูลสำเร็จ
                        // ทำตามขั้นตอนที่คุณต้องการเพิ่มเติม
                    } else {
                        // ไม่สามารถเพิ่มข้อมูลได้
                    }
                }
                if ($deliveryCheckval3 !== '') {
                    $sql_insert_delivery_3 = "INSERT INTO info_delivery_equipment (
                    ist_id,
                    mde_id,
                    ide_status_flg,
                    ide_created_date,
                    ide_created_by)
                    VALUES ('$ist_id','$deliveryCheckval3',1,NOW(),'$sess')";

                    $query_insert_delivery_3 = $this->db->query($sql_insert_delivery_3);

                    if ($this->db->affected_rows() > 0) {
                        // เพิ่มข้อมูลสำเร็จ
                        // ทำตามขั้นตอนที่คุณต้องการเพิ่มเติม
                    } else {
                        // ไม่สามารถเพิ่มข้อมูลได้
                    }
                }
                if ($deliveryCheckval4 !== '') {
                    $sql_insert_delivery_4 = "INSERT INTO info_delivery_equipment (
                    ist_id,
                    mde_id,
                    ide_status_flg,
                    ide_created_date,
                    ide_created_by)
                    VALUES ('$ist_id','$deliveryCheckval4',1,NOW(),'$sess')";

                    $query_insert_delivery_4 = $this->db->query($sql_insert_delivery_4);

                    if ($this->db->affected_rows() > 0) {
                        // เพิ่มข้อมูลสำเร็จ
                        // ทำตามขั้นตอนที่คุณต้องการเพิ่มเติม
                    } else {
                        // ไม่สามารถเพิ่มข้อมูลได้
                    }
                }
                if ($deliveryCheckval5 !== '') {
                    $sql_insert_delivery_5 = "INSERT INTO info_delivery_equipment (
                    ist_id,
                    mde_id,
                    ide_status_flg,
                    ide_created_date,
                    ide_created_by)
                    VALUES ('$ist_id','$deliveryCheckval5',1,NOW(),'$sess')";

                    $query_insert_delivery_5 = $this->db->query($sql_insert_delivery_5);

                    if ($this->db->affected_rows() > 0) {
                        // เพิ่มข้อมูลสำเร็จ
                        // ทำตามขั้นตอนที่คุณต้องการเพิ่มเติม
                    } else {
                        // ไม่สามารถเพิ่มข้อมูลได้
                    }
                }
                if ($deliveryCheckval6 !== '') {
                    $sql_insert_delivery_6 = "INSERT INTO info_delivery_equipment (
                    ist_id,
                    mde_id,
                    ide_status_flg,
                    ide_created_date,
                    ide_created_by)
                    VALUES ('$ist_id','$deliveryCheckval6',1,NOW(),'$sess')";

                    $query_insert_delivery_6 = $this->db->query($sql_insert_delivery_6);

                    if ($this->db->affected_rows() > 0) {
                        // เพิ่มข้อมูลสำเร็จ
                        // ทำตามขั้นตอนที่คุณต้องการเพิ่มเติม
                    } else {
                        // ไม่สามารถเพิ่มข้อมูลได้
                    }
                }

                $sql_insert_analyzdetail = "INSERT INTO info_analyze_problem (
                    ist_id,
                    iap_detail,
                    iap_pic1,
                    iap_pic2,
                    iap_pic3,
                    iap_path,
                    iap_status_flg,
                    iap_created_date,
                    iap_created_by
                    ) VALUES ('$ist_id','$analyzdetail','$anafileName1','$anafileName2','$anafileName3','assets/img/upload/analyz/',1,NOW(),'$sess')";

                $query_insert_analyzdetail = $this->db->query($sql_insert_analyzdetail);





                if ($analyzcheck1 !== '') {
                    $sql_insert_analyzcheck1 = "INSERT INTO info_analyze_problem (
                        ist_id,
                        map_id,
                        iap_status_flg,
                        iap_created_date,
                        iap_created_by
                        ) VALUES ('$ist_id',$analyzcheck1,1,NOW(),'$sess')";

                    $query_insert_analyzcheck1 = $this->db->query($sql_insert_analyzcheck1);

                    if ($this->db->affected_rows() > 0) {
                    } else {
                    }
                }

                if ($analyzcheck2 !== '') {
                    $sql_insert_analyzcheck2 = "INSERT INTO info_analyze_problem (
                        ist_id,
                        map_id,
                        iap_status_flg,
                        iap_created_date,
                        iap_created_by
                        ) VALUES ('$ist_id',$analyzcheck2,1,NOW(),'$sess')";

                    $query_insert_analyzcheck2 = $this->db->query($sql_insert_analyzcheck2);

                    if ($this->db->affected_rows() > 0) {
                    } else {
                    }
                }

                if ($analyzcheck3 !== '') {
                    $sql_insert_analyzcheck3 = "INSERT INTO info_analyze_problem (
                        ist_id,
                        map_id,
                        iap_status_flg,
                        iap_created_date,
                        iap_created_by
                        ) VALUES ('$ist_id',$analyzcheck3,1,NOW(),'$sess')";

                    $query_insert_analyzcheck3 = $this->db->query($sql_insert_analyzcheck3);

                    if ($this->db->affected_rows() > 0) {
                    } else {
                    }
                }

                if ($analyzcheck4 !== '') {
                    $sql_insert_analyzcheck4 = "INSERT INTO info_analyze_problem (
                        ist_id,
                        map_id,
                        iap_status_flg,
                        iap_created_date,
                        iap_created_by
                        ) VALUES ('$ist_id',$analyzcheck4,1,NOW(),'$sess')";

                    $query_insert_analyzcheck4 = $this->db->query($sql_insert_analyzcheck4);

                    if ($this->db->affected_rows() > 0) {
                    } else {
                    }
                }

                if ($analyzcheck5 !== '') {
                    $sql_insert_analyzcheck5 = "INSERT INTO info_analyze_problem (
                        ist_id,
                        map_id,
                        iap_status_flg,
                        iap_created_date,
                        iap_created_by
                        ) VALUES ('$ist_id',$analyzcheck5,1,NOW(),'$sess')";

                    $query_insert_analyzcheck5 = $this->db->query($sql_insert_analyzcheck5);

                    if ($this->db->affected_rows() > 0) {
                    } else {
                    }
                }

                if ($analyzcheck6 !== '') {
                    $sql_insert_analyzcheck6 = "INSERT INTO info_analyze_problem (
                        ist_id,
                        map_id,
                        iap_status_flg,
                        iap_created_date,
                        iap_created_by
                        ) VALUES ('$ist_id',$analyzcheck6,1,NOW(),'$sess')";

                    $query_insert_analyzcheck6 = $this->db->query($sql_insert_analyzcheck6);

                    if ($this->db->affected_rows() > 0) {
                    } else {
                    }
                }

                if ($analyzcheck7 !== '') {
                    $sql_insert_analyzcheck7 = "INSERT INTO info_analyze_problem (
                        ist_id,
                        map_id,
                        iap_status_flg,
                        iap_created_date,
                        iap_created_by
                        ) VALUES ('$ist_id',$analyzcheck7,1,NOW(),'$sess')";

                    $query_insert_analyzcheck7 = $this->db->query($sql_insert_analyzcheck7);

                    if ($this->db->affected_rows() > 0) {
                    } else {
                    }
                }

                if ($analyzcheck8 !== '') {
                    $sql_insert_analyzcheck8 = "INSERT INTO info_analyze_problem (
                        ist_id,
                        map_id,
                        iap_status_flg,
                        iap_created_date,
                        iap_created_by
                        ) VALUES ('$ist_id',$analyzcheck8,1,NOW(),'$sess')";

                    $query_insert_analyzcheck8 = $this->db->query($sql_insert_analyzcheck8);

                    if ($this->db->affected_rows() > 0) {
                    } else {
                    }
                }

                if ($analyzcheck9 !== '') {
                    $sql_insert_analyzcheck9 = "INSERT INTO info_analyze_problem (
                        ist_id,
                        map_id,
                        iap_status_flg,
                        iap_created_date,
                        iap_created_by
                        ) VALUES ('$ist_id',$analyzcheck9,1,NOW(),'$sess')";

                    $query_insert_analyzcheck9 = $this->db->query($sql_insert_analyzcheck9);

                    if ($this->db->affected_rows() > 0) {
                    } else {
                    }
                }

                if ($analyzcheck10 !== '') {
                    $sql_insert_analyzcheck10 = "INSERT INTO info_analyze_problem (
                        ist_id,
                        map_id,
                        iap_status_flg,
                        iap_created_date,
                        iap_created_by
                        ) VALUES ('$ist_id',$analyzcheck10,1,NOW(),'$sess')";

                    $query_insert_analyzcheck10 = $this->db->query($sql_insert_analyzcheck10);

                    if ($this->db->affected_rows() > 0) {
                    } else {
                    }
                }

                if ($analyzcheck11 !== '') {
                    $sql_insert_analyzcheck11 = "INSERT INTO info_analyze_problem (
                        ist_id,
                        map_id,
                        iap_detail,
                        iap_status_flg,
                        iap_created_date,
                        iap_created_by
                        ) VALUES ('$ist_id',$analyzcheck11,'$detailcheck11',1,NOW(),'$sess')";

                    $query_insert_analyzcheck11 = $this->db->query($sql_insert_analyzcheck11);

                    if ($this->db->affected_rows() > 0) {
                    } else {
                    }
                }



                $prevenArray = json_decode($data['PreventionallValues'], true);
                foreach ($prevenArray as $value) {
                    // ใช้ array_values() เพื่อดึงค่าทั้งหมดในแต่ละอาร์เรย์
                    $keys = array_keys($value);
                    $suggest = $value[$keys[0]];
                    $operated = $value[$keys[1]];
                    $schedul = $value[$keys[2]];
                    

                    // ทำการ query
                    $sql_insert_prevention = "INSERT INTO info_prevention_recurrence (
                        ist_id,
                        ipr_suggestions,
                        ipr_operated,
                        ipr_schedule,
                        ipr_status_flg,
                        ipr_created_date,
                        ipr_created_by
                    )
                    VALUES
                        (
                            '$ist_id',
                            '$suggest',
                            '$operated',
                            '$schedul',
                            1,
                            NOW(),
                            '$sess' 
                        )";

                    // ทำการ query
                    $query_insert_prevention = $this->db->query($sql_insert_prevention);
                    if ($this->db->affected_rows() > 0) {
                        $preven_status = 1;
                    } else {
                        $preven_status = 0;
                    }
                }



                $partRqArray = json_decode($data['rowDataArray'], true);
                for ($i = 0; $i < count($partRqArray); $i++) {
                    $data = $partRqArray[$i];
                    $maker = $data['Maker'];
                    $model = $data['Model'];
                    $name = $data['Name'];
                    $order = $data['Order'];
                    $orderQty = $data['OrderQty'];
                    $qty = $data['Qty'];
                    $received = $data['Received'];
                    $receivedQty = $data['ReceivedQty'];
                    $stock = $data['Stock'];
                    $stockQty = $data['StockQty'];
                    $type = $data['Type'];

                    // ทำการ query
                    $sql_insert_req = "INSERT INTO info_required_parts (
                    ist_id,
                    irp_name,
                    irp_maker,
                    irp_model,
                    irp_type,
                    irp_qty,
                    irp_withdraw_time,
                    irp_withdraw_qty,
                    irp_order_time,
                    irp_order_qty,
                    irp_received_time,
                    irp_received_qty,
                    irp_status_flg,
                    irp_created_date,
                    irp_created_by 
                )
                VALUES
                    (
                        '$ist_id',
                        '$name',
                        '$maker',
                        '$model',
                        '$type',
                        '$qty',
                        '$stock',
                        '$stockQty',
                        '$order',
                        '$orderQty',
                        '$received',
                        '$receivedQty',
                        1,
                        NOW(),
                        '$sess' 
                    )";

                    // ทำการ query
                    $query_insert_req = $this->db->query($sql_insert_req);

                    // ตรวจสอบว่า query สำเร็จหรือไม่
                    if ($this->db->affected_rows() > 0) {
                        $reqPart_status = 1;
                    } else {
                        $reqPart_status = 0;
                    }
                }


                if ($this->db->affected_rows() > 0) {
                    // INSERT INTO info_inspection_method
                    $sql_insert_inspection_method = "INSERT INTO info_inspection_method (
                    ist_id,
                    mim_id,
                    iim_detail,
                    iim_pic_1,
                    iim_pic_2,
                    iim_pic_3,
                    iim_path,
                    iim_status_flg,
                    iim_created_date,
                    iim_created_by
                ) VALUES ('$ist_id','$ispec','$ispecdetail','$insfileName1','$insfileName2','$insfileName3','assets/img/upload/inspection/',1,NOW(),'$sess')";

                    $query_insert_inspection_method = $this->db->query($sql_insert_inspection_method);

                    if ($this->db->affected_rows() > 0) {
                        return array('result' => 1, 'ist_id' => $ist_id); // Insert สำเร็จ
                    } else {
                        return array('result' => 0, 'message' => 'Insert ล้มเหลวในตาราง info_inspection_method');
                    }
                } else {
                    return array('result' => 0, 'message' => 'Insert ล้มเหลวในตาราง info_problem_condition');
                }
            } else {
                return array('result' => 0, 'message' => 'ไม่สามารถดึง ist_id ได้');
            }
        } else {
            return array('result' => 0, 'message' => 'Insert ล้มเหลวในตาราง info_issue_ticket');
        }
    }



    public function get_reqCode()
    {
        $month = date('Ym');
        $sql = "SELECT * FROM info_issue_ticket WHERE ist_job_no like '$month%'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $row = count($result);
        $code = $month;
        if ($row != 0) {
            $row++;
            if ($row >= 1000) {
                $code .= $row;
            } else if ($row >= 100) {
                $code .= "0" . $row;
            } else if ($row >= 10) {
                $code .= "00" . $row;
            } else if ($row >= 1) {
                $code .= "000" . $row;
            }
        } else {
            $code .= "0001";
        }
        return $code;
    }
}
