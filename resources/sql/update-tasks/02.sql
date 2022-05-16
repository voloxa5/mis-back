-- 2. вставка задания
insert into proger.tasks(kaskad_id,
                         created_at_p,
                         created_at,
                         updated_at,
                         alias_Name,
                         task_Number,
                         initiator_Full_Name,
                         initiator_Phone,
                         reg_Date,
                         work_Direction_Id,
                         initiator_Unit_Id,
                         urgent,
                         case_Number,
                         op_Acc_Type_Id,
                         in_Archive,
                         completed,
                         addressee_full_name,
                         addressee_rank_id,
                         ADDRESSEE_UNIT,
                         addressee_post_id)
SELECT id_obj                                                                                      kaskad_id,
       sysdate,
       date_reg                                                                                    created_at,
       date_modif                                                                                  updated_at,
       P_23                                                                                        alias_Name,          --Условное наименование дела
       p_21                                                                                        task_Number,         --Номер задания №
       p_35                                                                                        initiator_Full_Name, --Инициатор - Ф.И.О.
       p_36                                                                                        initiator_Phone,     --Инициатор - Телефон
       p_22                                                                                        reg_Date,            --Дата регистрации
       (select id from proger.DICT_WORK_DIRECTIONS where kaskad_id = p_20)                         work_Direction_Id,   --Направление работы
       (select id from proger.DICT_initiator_UnitS where kaskad_id = p_32)                         initiator_Unit_Id,   --Инициатор - Подразделение
       decode(p_39, 4077, 0, 216, 1, 0)                                                            urgent,              --срочность
       p_29                                                                                        case_Number,         --Дело №
       (select id from proger.DICT_op_Acc_TypeS where kaskad_id = p_28)                            op_Acc_Type_Id,      --Вид оперативного учета
       decode(updated, 0, 1, 1, 0, 0)                                                              in_Archive,
       decode(p_45, 101, 1, 102, 0, null)                                                          completed,           --Признак исполнения
       (select substr(FAMILY, 1, 1) || lower(substr(FAMILY, 2)) || ' ' || substr(FIRST_NAME, 0, 1) || '.' ||
               substr(PATRONYMIC, 0, 1) || '.'
        from K_0540.HEADS_OF_DEPARTMENTS
        where p_4016 = id_department)                                                              addressee_full_name,
       (select dict_ranks.id
        from K_0540.HEADS_OF_DEPARTMENTS,
             PROGER.dict_ranks
        where p_4016 = id_department
          and dict_ranks.kaskad_id = id_rank)                                                      addressee_rank_id,
       (select DATIVE_DEPARTMENT from K_0540.HEADS_OF_DEPARTMENTS where p_4016 = id_department)    addressee_unit,
       (select dict_posts.id
        from K_0540.HEADS_OF_DEPARTMENTS,
             PROGER.dict_posts
        where p_4016 = id_department
          and lower(trim(dict_posts.value)) =
              decode(lower(trim(staff_post)), 'начальнику', 'начальник', lower(trim(staff_post)))) addressee_post_id
FROM k_0540.t_3
WHERE id_obj = :v_id_z
  and not exists(select 1 from proger.tasks where kaskad_id = t_3.id_obj)
