namespace ProducerKafka.Models
{
    public class MessageKafka
    {
        public string Message { get; set; }
        public Topic Topic { get; set; }

        public MessageKafka(string message, Topic topic)
        {
            this.Message = message;
            this.Topic = topic;
        }
    }
}