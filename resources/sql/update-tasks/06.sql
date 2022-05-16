--6. удаление остутствующей характеристики связи
delete from PROGER.CRIME_CHARACTERIZATIONS where exists (select 1 from proger.tasks
                                                         where CRIME_CHARACTERIZATIONS.TASK_ID=tasks.id and kaskad_id=:v_id_z)
                                             and not exists
        (
        select 1
        from k_0540.char_obj_4, proger.tasks
        where
                id_param=27
          and id_obj=:v_id_z
          and tasks.kaskad_id=char_obj_4.id_obj
          and trim(CRIME_CHARACTERIZATIONS.NOTE)=trim(char_obj_4.val)
          and CRIME_CHARACTERIZATIONS.task_id=tasks.id
        )
