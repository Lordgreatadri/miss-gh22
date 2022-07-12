<?php 
	/**------------------------------------------------------------------------------------------------------------------------------------------------
	 * @@Name:              Hubtel_endpoint
	 
	 * @@Author:            Lordgreat -  Adri Emmanuel <'rexmerlo@gmail.com'>
	 * @@Tell:              +233543645688/+233273593525
	 
	 * @Date:               2022-04-11 12:30:30
	 * @Last Modified by:   Lordgreat -  Adri Emmanuel
	 * @Last Modified time: 2022-04-11 15:00:10

	 * @Copyright:          MobileContent.Com Ltd <'owner'>
	 
	 * @Website:            https://mobilecontent.com.gh
	 *-------------------------------------------------------------------------------------------------------------------------------------------------
	 */

	require_once 'includes/autoloader.inc.php';

	// echo "Hello world....am here";

/*
Array
(
    [ResponseCode] => 2001
    [Message] => failed
    [Data] => Array
        (
            [Amount] => 0.01
            [Charges] => 0.01
            [AmountAfterCharges] => 0
            [Description] => Transaction Failed
            [ClientReference] => 23214
            [TransactionId] => d51b6638c11c4ebf8383a65f0bc02c16
            [ExternalTransactionId] => 12214033545
            [AmountCharged] => 0.01
            [OrderId] => d51b6638c11c4ebf8383a65f0bc02c16
        )

)
*/

    $callback_obj = file_get_contents("php://input");
    $json = json_decode($callback_obj, true);

    file_put_contents('logs/endpoints.log', print_r($json, true));

    $ResponseCode = $json['ResponseCode'];//'0000';//
    $AmountAfterCharges = $json['Data']['AmountAfterCharges'];//'';//
    $TransactionId =  $json['Data']['TransactionId'];//'1e0315bf9169472bae0825d3df73af0a';//
    $ClientReference = $json['Data']['ClientReference'];//'';//
    $Description = $json['Data']['Description'];//'';//
    $ExternalTransactionId = $json['Data']['ExternalTransactionId'];//'';//
    $Amount = $json['Data']['Amount'];//'';//
    $Charges = $json['Data']['Charges'];//'';//




    $contestant_name = "";
    $contestant_id   = "";
    $contestant_num  = "";
    $amount_billed   = "";
    $description     = "";
    $voting_number   = "";
    $channel_type    = "";
    $device          = "";
    $vote_count      = 0;
    $current_votes   = 0;
    $current_weekly  = 0;



    $transactions_completed = new momo_data_auth();

    $updated_at = date("Y-m-d H:i:s");
    // update current payment initiation status.............
    $transactions_completed->update_initiator_status('Completed', $updated_at, $TransactionId);


    // get payment initiation record...........
    foreach ($transactions_completed->get_user_data($TransactionId) as $keyValue) 
    {
    	$contestant_name = $keyValue["contestant_name"];
	    $contestant_id   = $keyValue["contestant_id"];
	    $contestant_num  = $keyValue["contestant_num"];
	    $amount_billed   = $keyValue["amount"];
	    $voting_number   = $keyValue["momo_number"];
	    $channel_type    = $keyValue["channel"];
	    $device          = $keyValue["device"];
	    $vote_count      = $keyValue['vote_count'];
        $category        = $keyValue['category'];

        // var_dump($vote_count);
    }



    // // log completed callback data to db................
    $transactions_completed->logPaymentCallbackResponse($TransactionId, $ExternalTransactionId, $ResponseCode, $AmountAfterCharges, $Charges, $voting_number, $channel_type, $amount_billed, $contestant_name, $contestant_num, $contestant_id, $vote_count, $device, $Description, $ClientReference, $category);


    // check if payment succeed for valid voting.........
    if(trim($ResponseCode) == '0000') 
    {
        $vote_date = date("Y-m-d H:i:s");
    	// now get lucky contestants to award votes.............
    	foreach ($transactions_completed->get_current_contestant_data($contestant_id, $contestant_num) as $key) 
    	{
    		$current_votes = $key['vote_count'];
    		$contestant_id = $key['contestant_id'];
    		$contestant_num = $key['contestant_num'];

    		$new_votes = $current_votes + $vote_count;

    		// credit new votes............
    		$transactions_completed->update_vote_counts($new_votes, $contestant_id, $contestant_num, $vote_date);
            // var_dump($current_votes);
    	}


        foreach($transactions_completed->get_contestant_weekly_data($contestant_id, $contestant_num) as $row)
        {
            $wcurrent_votes  = $row['vote_count'];
            $wcontestant_id  = $row['contestant_id'];
            $wcontestant_num = $row['contestant_num'];

            $vote_date = date("Y-m-d H:i:s");
            $newweekly_votes = $wcurrent_votes + $vote_count;;

           $transactions_completed->update_weekly_vote_counts($newweekly_votes, $wcontestant_id, $wcontestant_num, $vote_date);
        }







        // #do channel votes update..............
        // foreach($transactions_completed->get_channel_votes_data($contestant_id, $contestant_num) as $channels) 
        // {
        //     $vote_date = date("Y-m-d H:i:s");
        //     $ccontestant_id  = $channels['contestant_id'];
        //     $ccontestant_num = $channels['contestant_num'];
        //     $old_votes = $channels['vote_count'];
        //     $old_web   = $channels['online'];
        //     $old_ussd  = $channels['ussd'];

        //     $new_channel_votes = 0;


        //     // check which channel this vote is ment for......
        //     if (trim($device) == "ussd") 
        //     {
        //         $new_channel_votes = $vote_count + $old_votes;
        //         $new_ussd = $old_ussd + $vote_count;

        //         // update ussd channels......
        //         $transactions_completed->update_channel_votes_counts($new_channel_votes, $ccontestant_id, $ccontestant_num, "ussd", $new_ussd, $vote_date);
        //     }elseif(trim($device) == "online") 
        //     {
        //         $new_channel_votes = $vote_count + $old_votes;
        //         $new_web   = $old_web + $vote_count;

        //         // update online channels.......
        //         $transactions_completed->update_channel_votes_counts($new_channel_votes, $ccontestant_id, $ccontestant_num, "online", $new_web, $vote_date);
        //     }
            

        // }

        //notify user of vote status...
        $message = "Miss Ghana:\nYou have voted successfully for '$contestant_name'\nPowered by mobilecontent.com.gh\nVote online: bit.ly/missgha";

        $transactions_completed->sendUserResponse($voting_number, $message);

    } else 
    {
        //notify user of vote status...
        $message = "Miss Ghana:\nPayment failed for '$contestant_name', ".$Description."\nPowered by mobilecontent.com.gh\nVote online: bit.ly/missgha";

        $transactions_completed->sendUserResponse($voting_number, $message);	
    }
    

