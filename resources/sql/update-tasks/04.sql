-- 4. пометить задание, если оно отстутствует в К.
update proger.tasks set tasks.kaskad_id=0, updated_at_p=sysdate
where
not exists (
  select 1 from k_0540.t_3 WHERE tasks.kaskad_id=t_3.id_obj
)
and in_Archive=0
and nvl(completed,0)=0
