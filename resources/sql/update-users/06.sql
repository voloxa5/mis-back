--связываем личные группы и контейнерные группы посредством разбора имени пользователя
merge into proger.group_groups target
using (select folderGroup.id parent_id, userGroups.id child_id
       from (select groups.id,
                    'gr' || upper(regexp_substr(users.NAME, 'user(\d?\D*(\d?ruk|ruk)?|zam1)', 1, 1, null, 1)) key
             from proger.groups,
                  proger.users
             where groups.user_id = users.ID) userGroups,
            (select * from proger.groups where user_id is null) folderGroup
       where userGroups.key = folderGroup.name
)
    source
on (source.parent_id = target.parent_id and source.child_id = target.child_id)
when not matched
    then
    insert (target.parent_id, target.child_id)
    values (source.parent_id, source.child_id)
