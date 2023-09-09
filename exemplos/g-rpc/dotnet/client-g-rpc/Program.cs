using cliente_g_rpc.Protos;
using cliente_g_rpc.Services;
using Grpc.Net.Client;

class Program
{
    static async Task Main(string[] args)
    {
        var userService = new UserService();
        var userStream = userService.NewUserStream("Edilson", "Santos");
        await foreach(UserReply user in userStream)
        {
            Console.WriteLine($"{DateTime.Now.ToString("hh:mm:ss.fff")} - {user.Message}");
            await Task.Delay(10000);
        }

        Console.ReadKey();
    }

    
}