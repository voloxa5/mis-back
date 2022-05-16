<?php


namespace App\Http\Controllers;


use App\LogLaunch;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

function fullName($value): string
{
    return !$value ? '' : mb_substr(mb_strtoupper($value['surname']), 0, 1) .
        mb_substr(mb_strtolower($value['surname']), 1) . ' ' .
        mb_substr(mb_strtoupper($value['name']), 0, 1) . '.' .
        mb_substr(mb_strtoupper($value['patronymic']), 0, 1) . '.';
}

class VoluntaryController extends Controller
{
    public function documentInfo(Request $request)
    {
        try {
            $document = collect(DB::select(
                'select document_reg_number, log_reg_number,
       is_marked_delete, marked_delete_date,
       (select title from groups where id = marked_delete_group_id) markedDeleteGroup,
       (select title from groups where id = addressee_id) addressee,
       (select title from groups where id = creator_id) creator,
       (select title from groups where id = owner_id) owner,
       (select title from groups where id = sender_id) sender,
       (select guid from dict_secrecy_degrees where id = secrecy_degree_id) secrecyDegreeGuid,
       updated_at updatedAt
from documents where id=:id', ['id' => $request['id']]))->first();

            $movingDocumentsLogs = DB::select('select (select title from groups where id = sender_id) sender,
       (select title from groups where id = owner_id) owner,
       (select title from groups where id = addressee_id) addressee, created_at createdAt
from moving_documents_logs where document_id=:id', ['id' => $request['id']]);

            $signatures = DB::select('select signatures.title, signature_date signatureDate
from signatures join documents on signatures.content_hash=documents.content_hash
where documents.id=:id and signatures.document_id=:id order by signature_date', ['id' => $request['id']]);

            $documentLocks = DB::select("select lock_time lockTime,
       employees.surname , employees.name , employees.patronymic
from document_locks join users on document_locks.user_id = users.id join employees on users.id = employees.user_id
where document_id=:id", ['id' => $request['id']]);

            $result = $document ?
                [
                    'documentRegNumber' => $document->document_reg_number,
                    'logRegNumber' => $document->log_reg_number,
                    'addressee' => $document->addressee,
                    'creator' => $document->creator,
                    'owner' => $document->owner,
                    'sender' => $document->sender,
                    'updatedAt' => $document->updatedAt,
                    'isMarkedDelete' => $document->is_marked_delete,
                    'markedDeleteGroup' => $document->markedDeleteGroup,
                    'markedDeleteDate' => $document->marked_delete_date,
                    'secrecyDegree' => $document->secrecyDegreeGuid === 30 ? 'с' : ($document->secrecyDegreeGuid === 31 ? 'сс' : 'дсп'),
                    'movingDocumentsLogs' => $movingDocumentsLogs,
                    'signatures' => $signatures,
                    'documentLock' => $documentLocks ? collect($documentLocks)->first() : null
                ] : null;

            return response($result, Response::HTTP_OK);

        } catch (Exception $e) {
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function programStart(Request $request)
    {
        try {
            $item = new LogLaunch();
            $item->start_time = Carbon::now();
            $item->user_id = $request['id'];
            $item->save();

            return response(1, Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function programExit(Request $request)
    {
        try {
            $item = LogLaunch::findOrFail($request['id']);
            $item->exit_time = Carbon::now();
            $item->save();

            return response(1, Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function hasSignature(Request $request)
    {
        try {
            $signatures = DB::select('select 1 from signatures
where document_id=:id and actual=1', ['id' => $request['id']]);
            return response(count($signatures) > 0 ? 1 : 0, Response::HTTP_OK);
        } catch (Exception $e) {
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function clearLog(Request $request)
    {
        try {
            $laravelLog = storage_path('logs\laravel.log');
            file_put_contents($laravelLog, '');

            return response('File "' . $laravelLog . '" is cleared.', Response::HTTP_OK);
        } catch (Exception $e) {
            return response('error clearLog', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getRegNumberAndLogNumber(Request $request)
    {
        try {
            $year = $request['year'];

            //Узнаем рег-й номер журнала для группы в указанном году и виде делопроизводства
            $sqlRegNumber = 'select reg_number
from document_registration_logs
where (owner_group_id in (select parent_id from group_groups where child_id = :id) or owner_group_id = :id)
  and year_of_journal = :year
    and paperwork_type_id in (select id from paperwork_types where guid = :paperworkType)';

            $RegNumberRecords = DB::select($sqlRegNumber, [
                    'id' => $request['id'],
                    'year' => $year,
                    'paperworkType' => $request['paperworkType'],]
            );
            $logRegNumber = $RegNumberRecords[0]->reg_number;

            //Узнаем новый номер документа в этом журнале
            $minDate = Carbon::create($year - 1, 12, 31, 23, 59, 59);
            $maxDate = Carbon::create($year, 12, 31, 23, 59, 59);

            $sql = 'select max(document_reg_number) maxDocRegNumber from documents
where log_reg_number=:logRegNumber and document_reg_date>:minDate and document_reg_date<:maxDate';

            $log = DB::select($sql, [
                    'logRegNumber' => $logRegNumber,
                    'minDate' => $minDate,
                    'maxDate' => $maxDate]
            );
            $newDocRegNumber = $log[0]->maxDocRegNumber ? $log[0]->maxDocRegNumber + 1 : 1;

            return response(
                ['logRegNumber' => $logRegNumber, 'docRegNumber' => $newDocRegNumber],
                Response::HTTP_OK);
        } catch (Exception $e) {
            return response('error getRegNumberAndLogNumber', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getRegLogNumbers(Request $request)
    {
        try {
            $records = DB::select('select reg_number as logRegNumber, paperwork_type_id paperworkTypeId, owner_group_id
from document_registration_logs
where (owner_group_id in (select parent_id from group_groups where child_id = :groupId) or owner_group_id = :groupId)
  and year_of_journal = :regYear', [
                    'groupId' => $request['groupId'],
                    'regYear' => $request['regYear']]
            );
            \Log::info($records);
            return response($records, Response::HTTP_OK);
        } catch (Exception $e) {
            return response('error getLogNumbers', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getRankEmployee(Request $request)
    {
        try {
            $actualOn = $request['actualOn'];
            $employeeId = $request['employeeId'];
            $result = DB::select('SELECT * from(select (select value from dict_ranks where dict_ranks.id=employees.rank_id)
                         rank, 1 actual
              from employees where employees.id=:employeeId
              UNION ALL
              select (select value from dict_ranks where dict_ranks.id = emp_rank_instances.rank_id) rank, 0 actual
              from emp_rank_instances
              where employee_id = 1
                and actual_with < :actualOn
                AND actual_until >:actualOn) order by actual', [
                'employeeId' => $request['employeeId'],
                'actualOn' => $request['actualOn']
            ]);
            return response($result[0]->rank, Response::HTTP_OK);
        } catch (Exception $e) {
            return response('error getRankEmployee', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getPostEmployee(Request $request)
    {
        try {
            $actualOn = $request['actualOn'];
            $employeeId = $request['employeeId'];
            $result = DB::select('SELECT * from(select (select value from dict_posts where dict_posts.id=employees.post_id)
                         post, 1 actual
              from employees where employees.id=:employeeId
              UNION ALL
              select (select value from dict_posts where dict_posts.id = emp_post_instances.post_id) post, 0 actual
              from emp_post_instances
              where employee_id = 1
                and actual_with < :actualOn
                AND actual_until > :actualOn) order by actual', [
                'employeeId' => $request['employeeId'],
                'actualOn' => $request['actualOn']
            ]);
            return response($result[0]->post, Response::HTTP_OK);
        } catch (Exception $e) {
            return response('error getPostEmployee', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getSurnameEmployee(Request $request)
    {
        try {
            $actualOn = $request['actualOn'];
            $employeeId = $request['employeeId'];
            $result = DB::select('SELECT * from(SELECT(select surname from employees WHERE id=:employeeId)surname, 1 actual
 UNION ALL
select (select surname from emp_surname_instances
where employee_id = :employeeId
and actual_with < :actualOn
AND actual_until >:actualOn) surname, 0 actual) order by actual', [
                'employeeId' => $request['employeeId'],
                'actualOn' => $request['actualOn']
            ]);
            return response($result[0]->surname, Response::HTTP_OK);
        } catch (Exception $e) {
            return response('error getSurnameEmployee', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getWorkingEmployee(Request $request)
    {
        try {
            $actualOn = $request['actualOn'];
            $employeeId = $request['employeeId'];

            $result = DB::select('SELECT * from(SELECT(select surname from employees WHERE id=:employeeId)surname, 1 actual
 UNION ALL
select (select surname from emp_surname_instances
where employee_id = :employeeId
and actual_with < :actualOn
AND actual_until >:actualOn) surname, 0 actual) order by actual', [
                'employeeId' => $request['employeeId'],
                'actualOn' => $request['actualOn']
            ]);
            return response($result[0]->working, Response::HTTP_OK);
        } catch (Exception $e) {
            return response('error getWorkingEmployee', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
