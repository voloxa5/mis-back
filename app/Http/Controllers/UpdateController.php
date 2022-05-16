<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UpdateController extends Controller
{
    //обновление заданий
    public function updateTasksData(Request $request): Response
    {
        $resp = '';
        $id = -1;
        $i = 1;
        DB::beginTransaction();
        try {
            $tasks = DB::select(
                "SELECT id_obj, p_21 FROM k_0540.t_3
                       WHERE NVL (p_44, '0') <> '0'
                         AND SYSDATE - date_reg < 100
                         AND p_20 = 3451");
            //   AND NOT EXISTS (SELECT 1 FROM proger.tasks WHERE kaskad_id = id_obj)");

            $resp .= count($tasks) . ' records is processed. Numbers: ';
            foreach ($tasks as $task) {
                $resp .= (mb_substr($resp, -2) !== ': ' ? ', ' : '') . $task->p_21;
                $i = 1;
                for ($i; $i <= 40; $i++) {
                    $sql = file_get_contents(base_path() . '/resources/sql/update-tasks/' . str_pad($i, 2, '0', STR_PAD_LEFT) . '.sql');
                    $id = $task->id_obj;
                    $sql = str_replace(':v_id_z', $id, $sql);
                    DB::statement($sql);
//                    if (!strpos($sql, 'v_id_z'))
//                        DB::statement($sql);
//                    else
//                        DB::statement($sql, ['v_id_z' => $id]);
                }
            }
            DB::commit();
            return response($resp, ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            \Log::error($e);
            DB::rollBack();
            return response("{\"id\": $id, \"sql\": $i}", ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //кто не заходил в интегратор
    public function nullPwd(): Response
    {
        $sql = file_get_contents(base_path() . '/resources/sql/null_pwd.sql');
        return response(DB::select($sql), Response::HTTP_OK);
    }

    //обновление стат.полей
    public function updateTasks(Request $request): Response
    {
        $id = $request['id'];
        DB::beginTransaction();
        try {
            DB::update('MERGE INTO proger.tasks
     USING (SELECT t_131.id_obj_1     id_obj,
                   P_1041,
                   P_1077,
                   P_1154,
                   P_1094,
                   contens
              FROM K_0540.T_129, k_0540.t_131, k_0540.doc_obj
             WHERE     t_131.id_obj_1 = :id and doc_obj.id_obj=T_129.id_obj and doc_obj.id_param=4817
                   AND t_131.id_obj_2 = t_129.id_obj) source
        ON (source.id_obj = tasks.kaskad_id)
WHEN MATCHED
THEN
    UPDATE SET days_actually_worked = P_1041,
               identified_persons = P_1077,
               identified_addresses = P_1154,
               work_results = contens,
               photos = P_1094', ['id' => $id]);
            DB::commit();
            return response(1, Response::HTTP_OK);
        } catch (Exception $e) {
            \Log::error($e);
            DB::rollBack();
            return response(0, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updatePaperCase(Request $request): Response
    {
        $paperCaseCaption = $request['name'];
        $documentId = $request['document_id'];
        DB::beginTransaction();
        try {
            $pc = DB::select('select paper_cases.id from proger.paper_cases, proger.group_paper_cases
                                    where paper_cases.id=group_paper_cases.group_id(+) and short_caption=?', [$paperCaseCaption]);
            if ($pc) {
                DB::update('update proger.documents set paper_case_id=' . $pc[0]->id . ' where id=' . $documentId);
            } else {
                $paperCaseId = DB::table('paper_cases')->insertGetId(['short_caption' => $paperCaseCaption, 'caption' => $paperCaseCaption]);
                DB::update('update proger.documents set paper_case_id=' . $paperCaseId . ' where id=' . $documentId);
                $accesses = DB::select('select group_id from proger.group_documents where id=' . $documentId);
                if ($accesses) {
                    foreach ($accesses as $access) {
                        DB::table('group_paper_cases')->insert(['group_id' => $access->group_id, 'paper_case_id' => $paperCaseId]);
                    }
                } else {
                    $ownerId = DB::table('documents')->find($documentId)->owner_id;
                    DB::table('group_paper_cases')->insert(['group_id' => $ownerId, 'paper_case_id' => $paperCaseId]);
                }
            }

            DB::commit();
            return response(1, Response::HTTP_OK);
        } catch (Exception $e) {
            \Log::error($e);
            DB::rollBack();
            return response(0, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function changePwd(int $id, string $pwd): void
    {
        try {
            $user = User::find($id);
            $hash = Hash::make($pwd);
            $user->password = $hash;
            $user->save();
        } catch (Exception $e) {
            \Log::warning($e->getMessage());
        }
    }

    public function updatePwd(Request $request): Response
    {
        $resp = '';
        $id = -1;
        $pwd = '';
        DB::beginTransaction();
        try {
            $items = DB::select(
                "SELECT P_4030, pwd.VALUE as pwd, users.id FROM k_0540.pwd, K_0540.T_400, PROGER.USERS
                       WHERE PWD.ID = t_400.P_4030 AND t_400.P_4042 = 3858 AND NOT pwd.VALUE IS NULL AND USERS.ID_KASKAD=T_400.id_obj
                         ");

            $resp .= count($items) . ' records is processed.';
            foreach ($items as $item) {
                $id = $item->id;
                $pwd = $item->pwd;
                if ((substr($pwd, 0, 1) === '"') && (substr($pwd, -1) === '"')) {
                    $pwd = substr($pwd, 1, -1);
                }
                $this->changePwd((int)$id, $pwd);
            }
            DB::commit();
            return response($resp, ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            \Log::error($e);
            DB::rollBack();
            return response("{\"id\": $id, \"pwd\": $pwd}", ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //обновление заданий
    public function updateUsers(Request $request): Response
    {
        $i = 1;
        DB::beginTransaction();
        try {
            for ($i; $i <= 6; $i++) {
                $sql = file_get_contents(base_path() . '/resources/sql/update-users/' . str_pad($i, 2, '0', STR_PAD_LEFT) . '.sql');
                DB::statement($sql);
            }
            DB::commit();
            return response('All users updated successfully ', ResponseAlias::HTTP_OK);
        } catch (Exception $e) {
            \Log::error($e);
            DB::rollBack();
            return response($i, ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
