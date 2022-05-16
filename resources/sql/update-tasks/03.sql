/* Formatted on 28/02/2022 12:37:42 (QP5 v5.326) */
MERGE INTO proger.tasks
     USING (SELECT z.id_obj           kaskad_id,
                   z.date_modif           updated_at,
                   SYSDATE           updated_at_p,
                   z.P_23           alias_Name,                            --???????? ???????????? ????
                   z.p_21           task_Number,                                      --????? ??????? ?
                   z.p_35           initiator_Full_Name,                           --????????? - ?.?.?.
                   z.p_36           initiator_Phone,                              --????????? - ???????
                   z.p_22           reg_Date,
                   rr.P_1041           dney,
                   rr.p_1079           svaz,
                   rr.P_1154           adr,
                   rr.p_1094           foto,
                   (SELECT id
                    FROM proger.DICT_WORK_DIRECTIONS
                    WHERE kaskad_id = p_20)           work_Direction_Id,                             --Направление работы
                   (SELECT id
                    FROM proger.DICT_initiator_UnitS
                    WHERE kaskad_id = p_32)           initiator_Unit_Id,                      --Инициатор - Подразделение
                   DECODE (p_39,  4077, 0,  216, 1,  0)           urgent,                                                 --срочность
                   p_29           case_Number,                                               --Дело №
                   (SELECT id
                    FROM proger.DICT_op_Acc_TypeS
                    WHERE kaskad_id = p_28)           op_Acc_Type_Id,                            --Вид оперативного учета
                   DECODE (z.updated,  0, 1,  1, 0,  0)           in_Archive,
                   DECODE (p_45,  101, 1,  102, 0,  0)           completed,                                     --Признак исполнения
                   (SELECT    SUBSTR (FAMILY, 1, 1)
                                  || LOWER (SUBSTR (FAMILY, 2))
                                  || ' '
                                  || SUBSTR (FIRST_NAME, 0, 1)
                                  || '.'
                                  || SUBSTR (PATRONYMIC, 0, 1)
                                  || '.'
                    FROM K_0540.HEADS_OF_DEPARTMENTS
                    WHERE p_4016 = id_department)           addressee_full_name,
                   (SELECT dict_ranks.id
                    FROM K_0540.HEADS_OF_DEPARTMENTS, PROGER.dict_ranks
                    WHERE p_4016 = id_department AND dict_ranks.kaskad_id = id_rank)           addressee_rank_id,
                   (SELECT DATIVE_DEPARTMENT
                    FROM K_0540.HEADS_OF_DEPARTMENTS
                    WHERE p_4016 = id_department)           addressee_unit,
                   (SELECT dict_posts.id
                    FROM K_0540.HEADS_OF_DEPARTMENTS, PROGER.dict_posts
                    WHERE     p_4016 = id_department
                      AND LOWER (TRIM (dict_posts.VALUE)) =
                          DECODE (LOWER (TRIM (staff_post)),
                                  'начальнику', 'начальник',
                                  LOWER (TRIM (staff_post))))           addressee_post_id,
                   z.DATE_MODIF           date_modif,
                   TO_CHAR (contens)           rez
            FROM k_0540.t_129    rr,
                 k_0540.t_3      z,
                 k_0540.t_131    z_rr,
                 k_0540.doc_obj  rr_rez
            WHERE     z.id_obj = Z_RR.ID_OBJ_1
              AND Z_RR.ID_OBJ_2 = RR.ID_OBJ
              AND RR.ID_OBJ = rr_rez.id_obj
              and rr_rez.id_param =4817
              AND z.id_obj = :v_id_z
              AND EXISTS
                (SELECT 1
                 FROM proger.tasks
                 WHERE     tasks.kaskad_id = z.id_obj
                   AND z.date_modif <> tasks.updated_at))
           source
        ON (tasks.kaskad_id = source.kaskad_id)
WHEN MATCHED
THEN
    UPDATE SET tasks.updated_at = source.updated_at,
               tasks.updated_at_p = source.updated_at_p,
               tasks.alias_Name = source.alias_Name,
               tasks.task_Number = source.task_Number,
               tasks.initiator_Full_Name = source.initiator_Full_Name,
               tasks.initiator_Phone = source.initiator_Phone,
               tasks.reg_Date = source.reg_Date,
               tasks.work_Direction_Id = source.work_Direction_Id,
               tasks.initiator_Unit_Id = source.initiator_Unit_Id,
               tasks.urgent = source.urgent,
               tasks.case_Number = source.case_Number,
               tasks.op_Acc_Type_Id = source.op_Acc_Type_Id,
               tasks.in_Archive = source.in_Archive,
               tasks.completed = source.completed,
               tasks.addressee_full_name = source.addressee_full_name,
               tasks.addressee_rank_id = source.addressee_rank_id,
               tasks.addressee_unit = source.addressee_unit,
               tasks.addressee_post_id = source.addressee_post_id,
               tasks.DAYS_ACTUALLY_WORKED = source.dney, --?????????? ?????????? (???) p_1041
               tasks.IDENTIFIED_PERSONS = source.svaz, --??????????? ?????? p_1079
               tasks.IDENTIFIED_ADDRESSES = source.adr, -- ???????? ??????? p_1154
               tasks.PHOTOS = source.foto,             --????????? ???? ????? p_1094
               tasks.WORK_RESULTS=source.rez   --добавлено 15.03.2022
