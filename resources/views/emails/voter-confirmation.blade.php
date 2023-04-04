Dear {{ $voter->fullname }},<br><br>

Thank you for registering to vote in the upcoming election. Your registration details are as follows:<br><br>

Full Name: {{ $voter->fullname }}<br>
Address: {{ $voter->address }}<br>
Postcode: {{ $voter->postcode }}<br>
Region: {{ $voter->boundary ? $voter->boundary->region : '' }}<br>
Constituency: {{ $voter->boundary ? $voter->boundary->constituency : '' }}<br><br>


On the day of the election, you will receive an email with a link to cast your vote. <br>
Please be sure to check your inbox (and your spam folder) on that day. If you have any questions or concerns about the voting process, please do not hesitate to contact us.<br><br>

Thank you for your participation in the election.<br><br>

Best regards,<br><br>


Election Committee
