#!/usr/bin/env bash
while [ 1 ]
do
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=Order_Guard
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=Payment_CiticBank_Batch
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=Payment_CiticBank_Check
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=Payment_After
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=Order_Guard
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=Order_ActiveRepayment
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=Deduct_Queue
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=Deduct_QueueQuery
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=Order_Guard
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=PreAuth_Unionpay_Queue
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=PreAuth_Unionpay_Queue
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=PreAuth_Unionpay_Queue
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=Order_Guard
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=Deduct_Queue2
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=Deduct_QueueQuery2
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=Order_Guard
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=Order_UpAmount
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=Order_OverdueCalc
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=User_CreditExpire
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=User_OverdueM2Deny
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=Approval_Order
sleep 1
php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=SMS_Queue2
sleep 1









#php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash22/DEV/admin/modules/minion/minion --task=Approval_CreditAudit
#sleep 1




#php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash21/DEV/admin/modules/minion/minion --task=Order_IntoPreAuth
#sleep 1
#php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash21/DEV/admin/modules/minion/minion --task=Order_DueDay
#sleep 1
#sleep 1
#php /Applications/XAMPP/xamppfiles/htdocs/vhost/timecash21/DEV/admin/modules/minion/minion --task=Order_OverdueCalcComplete

done

