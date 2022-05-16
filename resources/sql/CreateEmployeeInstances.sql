insert into employee_instances(employee_id,
                               created_at,
                               updated_at,
                               surname,
                               callsign,
                               post_id,
                               rank_id,
                               working_id,
                               employees_unit_id,
                               is_actual)
select id as employee_id,
       created_at,
       updated_at,
       surname,
       callsign,
       post_id,
       rank_id,
       working_id,
       employees_unit_id,
       1
from employees

