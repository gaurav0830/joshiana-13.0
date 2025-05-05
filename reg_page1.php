<?php
session_start();
error_reporting(E_ALL); // Enable error reporting for debugging
include "config/db.php"; // Ensure this contains the correct database connection code
require ('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

// Initialize Razorpay with your key and secret
$api_key = 'rzp_test_lxMG7yWdmE65oc';
$api_secret = 'N9eDF85LigyRWIOOU2AwHJbr';

// Redirect if session data is missing
if (!isset($_SESSION['college']) || !isset($_SESSION['email']) || !isset($_SESSION['phone1']) || !isset($_SESSION['phone2']) || !isset($_SESSION['degree']) || !isset($_SESSION['department'])) {
	header("Location: reg.php");
	exit();
	}

// Fetch session data
$college = $_SESSION['college'];
$email = $_SESSION['email'];
$phone1 = $_SESSION['phone1'];
$phone2 = $_SESSION['phone2'];
$degree = $_SESSION['degree'];
$department = $_SESSION['department'];

$errors = [];

// Define pricing tiers
$pricePerParticipantLow = 150; // Price if participants are less than 4
$pricePerParticipantHigh = 100; // Price if participants are 4 or more

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Initialize session array
	$_SESSION['events'] = [];

	// Collect all participants to detect duplicates
	$allParticipants = [];
	$events = [];

	// Initialize total number of participants
	$totalParticipants = 0;



	foreach ($_POST['event'] as $index => $event) {
		if (empty($event) || $event == "Select Event*") {
			$errors["event_$index"] = "Please select a valid event.";
			continue;
			}

		// Initialize counters
		$filledParticipants = 0;

		$participants = [];
		for ($i = 0; $i <= count($_POST["participant" . ($index + 1)]); $i++) {
			if (isset($_POST["participant" . ($index + 1)][$i])) {
				$participant = trim($_POST["participant" . ($index + 1)][$i]);
				if (!empty($participant)) {
					// Add to list of all participants for duplicate checking
					$allParticipants[] = $participant;

					$participants[] = $participant;
					$filledParticipants++;
					}
				}
			}

		// Validate that there is at least one participant field filled
		if ($filledParticipants === 0) {
			$errors["participant_$index"] = "Please fill out at least one participant field.";
			} else {
			// Store participants if there are filled fields
			$_SESSION['events'][$index] = [
				'event' => $event,
				'participants' => $participants
			];


			// Add the filled participants to the total count for calculation
			$totalParticipants += $filledParticipants;
			$events[$index] = $event;

			}
		}

	// Check for duplicates
	$uniqueParticipants = count(array_unique($allParticipants));

	// If duplicates are found, exclude COSMIC BEAT participants from the total calculation


	// Determine the price per participant based on the total number of participants
	$pricePerParticipant = $uniqueParticipants <= 4 ? $pricePerParticipantLow : $pricePerParticipantHigh;

	// Calculate the total amount
	$totalAmount = $uniqueParticipants * $pricePerParticipant;

	// Ensure the total amount is at least the minimum allowed by Razorpay
	$minimumAmount = 1; // Adjust this based on Razorpay's actual minimum requirement
	if ($totalAmount < $minimumAmount) {
		$totalAmount = $minimumAmount;
		}
	// Check if there are any errors
	if (empty($errors)) {
		// Initialize Razorpay API
		$api = new Api($api_key, $api_secret);

		try {
			// Create an order
			$orderData = [
				'amount' => $totalAmount * 100, // Amount in paise
				'currency' => 'INR',
				'payment_capture' => 1 // Auto capture
			];
			$order = $api->order->create($orderData);

			// Store necessary data in the session
			$_SESSION['order_id'] = $order->id;
			$_SESSION['total_amount'] = $totalAmount;

			// Redirect to the payment page
			header("Location: payment_page.php");
			exit;
			} catch (\Exception $e) {
			// Handle Razorpay API errors
			$errors['payment'] = "Payment failed: " . $e->getMessage();
			}
		} else {
		// Output errors for debugging
		echo '<pre>Errors: ';
		print_r($errors);
		echo '</pre>';
		exit;
		}
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>JOSHIANA | 13.0</title>
	<link rel="icon" type="image/x-icon" href="images/fav-icon.png">
	<link rel="stylesheet" href="assests/css/reg.css" />
</head>

<body>
	<div class="container-reg">
		<h4>JOSHIANA <sup>13.0</sup></h4>
		<header>Registration Form</header>
		<p></p>
		<form method="post" class="form" id="myForm">
			<div class="input-box">
				<label for="College">College Address:</label>
				<input type="text" id="college"
					value="<?php echo htmlspecialchars($_SESSION['college']); ?>"
					readonly />
			</div>

			<div class="column">
				<div class="input-box">
					<label for="Phone1">Phone Number1:</label>
					<input type="phone" id="phone1"
						value="<?php echo htmlspecialchars($_SESSION['phone1']); ?>"
						readonly />
				</div>
				<div class="input-box">
					<label for="Phone2">Phone Number2:</label>
					<input type="phone" id="phone2"
						value="<?php echo htmlspecialchars($_SESSION['phone2']); ?>"
						readonly />
				</div>
			</div>
			<div class="input-box">
				<label for="Email Address">Email Address:</label>
				<input type="email" id="email"
					value="<?php echo htmlspecialchars($_SESSION['email']); ?>"
					readonly />
			</div>
			<div class="column">
				<div class="input-box">
					<label for="Degree">Degree:</label>
					<input type="text" id="degree"
						value="<?php echo htmlspecialchars($_SESSION['degree']); ?>"
						readonly />
				</div>
				<!-- <div class="input-box">
					<label for="Department">Department:</label>
					<input type="text" id="dept"
						value="<?php echo htmlspecialchars($_SESSION['department']); ?>"
						readonly />
				</div> -->
			</div>
		</form>
		<hr>
		<form id="eventForm" method="post" action="reg_page1.php" class="form1">
			<div id="selectContainer">
				<div class="input-box select-container">
					<label for="Department">Select an Event:</label>
					<div class="select-box">
						<select name="event[]" class="event-select">
							<option hidden>Select Event*</option>
							<option value="astrohack">ASTROHACK[ Coding ]
							</option>
							<option value="galactic webcraft">GALACTIC WEBCRAFT[
								Web Design ]</option>
							<option value="Interstellar Intellect">Interstellar
								Intellect[ IT Manager ]</option>
							<option value="infognite">INFOGNITE[ IT Quiz ]
							</option>
							<option value="futurewave">FUTUREWAVE[ Product
								Launch ]</option>
							<option value="CLOAKED">CLOAKED[ Surprise Event ]
							</option>
							<option value="OUTLAST">OUTLAST[ Team Event ]
							</option>
							<option value="COSMIC BEAT">COSMIC BEAT[ Dance ]
							</option>
							<option value="FRACTAL FORTUNE">FRACTAL FORTUNE[
								Treasure Hunt ]</option>
							<option value="STELLER STORIES">STELLER STORIES[
								Reel Making ]</option>
						</select>
						<div class="error"></div>
					</div>
					<div class="input-box" id="inputFields1">
						<!-- Participant fields will be dynamically added here -->
					</div>
				</div>
			</div>
			<button type="button" class="button" id="doneBtn">Done</button>
			<button type="button" class="button" id="addSelect">Add Another
				Event</button>
			<div class="total-info" style="padding-top:20px;">
				<input type="hidden" id="totalSelectBoxes"></p>
				<input type="hidden" id="totalInputFields"></>
				<p id="totalAmount" style="font-size:1rem;">Total Amount: ₹0</p>
			</div>
			<button type="submit" class="button">Register & PAY</button>

		</form>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', () => {
			const addSelectButton = document.getElementById('addSelect');
			const selectContainer = document.getElementById('selectContainer');
			let selectCounter = 1; // Start from 1 for the first set of inputs
			const MAX_SELECTS = 10;

			function createNewSelectBox () {
				selectCounter++;
				if (selectCounter > MAX_SELECTS) {
					alert(`You can only add up to ${MAX_SELECTS} events.`);
					return;
				}

				const index = selectCounter;
				const newDiv = document.createElement('div');
				newDiv.classList.add('input-box', 'select-container');
				newDiv.id = `selectBox${index}`;

				// Create a label for the select box
				const newLabel = document.createElement('label');
				newLabel.setAttribute('for', `event-select-${index}`);
				newLabel.textContent = `Select Event ${index}:`;

				const newSelect = document.createElement('select');
				newSelect.setAttribute('id', `event-select-${index}`);
				newSelect.setAttribute('name', `event[]`);
				newSelect.classList.add('event-select');
				newSelect.innerHTML = `
				<option hidden>Select Event*</option>
			<option value="astrohack">ASTROHACK [ Coding ]</option>
			<option value="galactic webcraft">GALACTIC WEBCRAFT [ Web Design ]</option>
			<option value="Interstellar Intellect">Interstellar Intellect [ IT Manager ]</option>
			<option value="infognite">INFOGNITE [ IT Quiz ]</option>
			<option value="futurewave">FUTUREWAVE [ Product Launch ]</option>
			<option value="CLOAKED">CLOAKED [ Surprise Event ]</option>
			<option value="OUTLAST">OUTLAST [ Team Event ]</option>
			<option value="COSMIC BEAT">COSMIC BEAT [ Dance ]</option>
			<option value="FRACTAL FORTUNE">FRACTAL FORTUNE [ Treasure Hunt ]</option>
			<option value="STELLER STORIES">STELLER STORIES [ Reel Making ]</option>
		`;

				const deleteButton = document.createElement('button');
				deleteButton.type = 'button';
				deleteButton.textContent = 'Delete';
				deleteButton.classList.add('delete-button');
				deleteButton.addEventListener('click', () => {
					deleteSelectBox(index);
				});

				newDiv.appendChild(newLabel);
				newDiv.appendChild(newSelect);
				newDiv.appendChild(deleteButton);

				// Add a container for participant input fields
				const newInputFieldsDiv = document.createElement('div');
				newInputFieldsDiv.classList.add('input-box');
				newInputFieldsDiv.id = `inputFields${index}`;
				newDiv.appendChild(newInputFieldsDiv);

				selectContainer.appendChild(newDiv);

				// Add event listener to the new select element
				newSelect.addEventListener('change', (event) => {
					const selectedValue = event.target.value;
					if (checkDuplicateSelection(selectedValue,
						index)) {
						alert(
							'This event has already been selected in another box.'
						);
						event.target.value = ''; // Reset the selection
						updateInputFields(event.target,
							newInputFieldsDiv);
					} else {
						updateInputFields(event.target,
							newInputFieldsDiv);
						updateCount();
					}
				});

				// Initialize the input fields for the new select box
				updateInputFields(newSelect, newInputFieldsDiv);
				updateCount(); // Update count when new select box is created
			}

			function checkDuplicateSelection (value, currentIndex) {
				const selectBoxes = document.querySelectorAll('.event-select');
				return Array.from(selectBoxes).some(selectBox => {
					// Check if the value exists in any select box except the current one
					return selectBox.value === value && selectBox
						.id !== `event-select-${currentIndex}`;
				});
			}

			function updateInputFields (selectElement, containerDiv) {
				const selectedValue = selectElement.value;
				let inputFieldsHTML = '';

				switch (selectedValue) {
					case 'astrohack':
					case 'Interstellar Intellect':
						inputFieldsHTML =
							`<input type="text" name="participant${selectCounter}[]" placeholder="Enter Participant Name 1:" maxlength="50"/><br>`;
						break;
					case 'galactic webcraft':
					case 'OUTLAST':
					case 'futurewave':
					case 'infognite':
					case 'CLOAKED':
						inputFieldsHTML = `
						<input type="text" name="participant${selectCounter}[]" placeholder="Enter Participant Name 1:" maxlength="50"/><br>
					<input type="text" name="participant${selectCounter}[]" placeholder="Enter Participant Name 2:" maxlength="50"/><br>
				`;
						break;
					case 'COSMIC BEAT':
						inputFieldsHTML = Array.from({
							length: 6
						}, (_, i) => `
						<input type="text" name="participant${selectCounter}[]" placeholder="Enter Participant Name ${i + 1}:" maxlength="50"/><br>
				`).join('');
						break;
					case 'FRACTAL FORTUNE':
						inputFieldsHTML = `
						<input type="text" name="participant${selectCounter}[]" placeholder="Enter Participant Name 1:" maxlength="50"/><br>
					<input type="text" name="participant${selectCounter}[]" placeholder="Enter Participant Name 2:" maxlength="50"/><br>
				`;
						break;
					case 'STELLER STORIES':
						inputFieldsHTML =
							`<input type="text" name="participant${selectCounter}[]" placeholder="Enter Participant Name 1:" maxlength="50"/><br>`;
						break;
					default:
						inputFieldsHTML = '';
						break;
				}


				containerDiv.innerHTML = inputFieldsHTML;

			}

			function deleteSelectBox (index) {
				const selectBoxDiv = document.getElementById(
					`selectBox${index}`);
				if (selectBoxDiv) {
					selectBoxDiv.remove();
					selectCounter--; // Decrement selectCounter
					updateCount();
				}
			}

			document.getElementById("doneBtn")
				.addEventListener('click',
					function () {
						updateCount()
					})

			function countFilledInputs () {

				const selectBoxes = document.querySelectorAll(
					'.select-container');
				const allParticipants = []
				selectBoxes.forEach(box => {
					const inputFields = box.querySelectorAll(
						'input[type="text"]');


					inputFields.forEach(input => {
						if (input.value.trim() !== '') {
							allParticipants.push(input.value
								.trim())
						}
					});

				});
				return new Set(allParticipants).size
			}

			function updateCount () {
				const totalFilledInputs = countFilledInputs();

				const pricePerParticipant = totalFilledInputs <= 4 ? 150 : 100;
				const totalAmount = totalFilledInputs * pricePerParticipant;

				const selectBoxes = document.querySelectorAll('.event-select');
				const totalSelectBoxes = selectBoxes.length;

				document.getElementById('totalSelectBoxes').innerText =
					`Total Select Boxes: ${totalSelectBoxes}`;
				document.getElementById('totalInputFields').innerText =
					`Total Input Fields: ${totalFilledInputs}`;
				document.getElementById('totalAmount').innerText =
					`Total Amount: ₹${totalAmount}`;
			}

			// Initialize the first select box
			const firstSelect = document.querySelector('.event-select');
			const firstInputFieldsDiv = document.getElementById(
				'inputFields1');

			firstSelect.addEventListener('change', (event) => {
				updateInputFields(event.target,
					firstInputFieldsDiv);
				updateCount();
			});


			// Add event listener to the Add Another Event button
			addSelectButton.addEventListener('click', () => {
				createNewSelectBox();
			});

			// Initial count update
			updateCount();
		});
	</script>
</body>

</html>