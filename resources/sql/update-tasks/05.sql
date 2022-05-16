-- 5. вставка характеристики задания
insert into PROGER.CRIME_CHARACTERIZATIONS(note,task_id)
select
  char_obj_4.val note,
  tasks.id task_id
from k_0540.char_obj_4, proger.tasks
where
id_param=27
and id_obj=:v_id_z
and tasks.kaskad_id = char_obj_4.id_obj
and not exists (select 1 from PROGER.CRIME_CHARACTERIZATIONS where trim(CRIME_CHARACTERIZATIONS.note)=trim(char_obj_4.val) and CRIME_CHARACTERIZATIONS.task_id=tasks.id)
