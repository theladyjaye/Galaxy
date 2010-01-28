//
//  ConstellationSampleAppDelegate.m
//  ConstellationSample
//
//  Created by Adam Venturella on 1/24/10.
//  Copyright __MyCompanyName__ 2010. All rights reserved.
//

#import "AppDelegate.h"
#import "Constellation.h"
#import "GalaxyForums.h"

@implementation AppDelegate

@synthesize window;
@synthesize navigation;

+ (Constellation * )constellationWithDelegate:(id<ConstellationDelegate>)delegate
{
	Constellation * constellation = [Constellation constellationWithDelegate:delegate];
	[constellation setApplicationId:@"com.galaxy.community"];
	[constellation setApplicationKey:@"849b35ec4988daa0dc5e77a0b30e8174"];
	[constellation setApplicationSecret:@"b86645d35804b4902d31e9c6ed0c989b"];
	return constellation;
}

- (void)applicationDidFinishLaunching:(UIApplication *)application {    

    // Override point for customization after application launch
	[window addSubview:navigation.view];
    [window makeKeyAndVisible];
}

- (void)galaxyCachedResponseForCommand:(GalaxyApplication *)application
{
	NSLog(@"%@", application);
}

- (BOOL)constellationShouldGetTopicsForForum:(Constellation *)constellation forum:(NSString *)forum
{
	return YES;
}

- (BOOL)constellationShouldGetForums:(Constellation *)constellation
{
	return YES;
}

- (void)dealloc {
    [window release];
	navigation = nil;
    [super dealloc];
}


@end
