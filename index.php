<?php

// Interface for order validation
interface OrderValidatorInterface {
    public function validate(array $orderData): void;
}

// Concrete order validator
class OrderValidator implements OrderValidatorInterface {
    public function validate(array $orderData): void {
        if (empty($orderData['product']) || empty($orderData['quantity'])) {
            throw new Exception("Invalid order data");
        }
    }
}

// Interface for order repository
interface OrderRepositoryInterface {
    public function save(array $orderData): void;
}

// Concrete order repository
class OrderRepository implements OrderRepositoryInterface {
    public function save(array $orderData): void {
        $conn = new mysqli("localhost", "root", "", "orders_db");
        $product = $conn->real_escape_string($orderData['product']);
        $quantity = (int)$orderData['quantity'];
        $sql = "INSERT INTO orders (product, quantity) VALUES ('$product', $quantity)";
        $conn->query($sql);
        $conn->close();
    }
}

// Interface for email sender
interface EmailSenderInterface {
    public function send(string $to, string $subject, string $message): void;
}

// Concrete email sender
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Make sure this path is correct

class EmailSender implements EmailSenderInterface {
    public function send(string $to, string $subject, string $message): void {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'f219063@cfd.nu.edu.pk'; // Your Gmail address
            $mail->Password   = '';    // App password, not your Gmail password!
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('your_gmail@gmail.com', 'Your Name');
            $mail->addAddress($to);

            //Content
            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
        } catch (Exception $e) {
            throw new Exception('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
        }
    }
}

// OrderProcessor depends on abstractions
class OrderProcessor {
    private $validator;
    private $repository;
    private $emailSender;

    public function __construct(
        OrderValidatorInterface $validator,
        OrderRepositoryInterface $repository,
        EmailSenderInterface $emailSender
    ) {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->emailSender = $emailSender;
    }

    public function processOrder(array $orderData): void {
        $this->validator->validate($orderData);
        $this->repository->save($orderData);
        $this->emailSender->send(
            $orderData['email'],
            "Order Confirmation",
            "Thank you for ordering " . $orderData['product']
        );
        echo "Order processed successfully!";
    }
}

// Example usage:
$orderData = [
    'product' => 'Book',
    'quantity' => 2,
    'email' => 'f219063@cfd.nu.edu.pk'
];

$validator = new OrderValidator();
$repository = new OrderRepository();
$emailSender = new EmailSender();
$processor = new OrderProcessor($validator, $repository, $emailSender);
$processor->processOrder($orderData);


